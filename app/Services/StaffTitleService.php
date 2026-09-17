<?php

namespace App\Services;

use App\Models\Staff;
use Illuminate\Support\Collection;

class StaffTitleService
{
    public function format(Staff $staff, bool $includeSuffixes = true): string
    {
        $staff->loadMissing([
            'professionalRecognitions.master',
            'honoraryTitles.master',
        ]);

        $honoraryPrefixes = $this->honoraryPrefixes($staff);
        $professionalPrefixes = $this->professionalPrefixes($staff);

        $hasYbhg = $staff->honoraryTitles->contains(function ($record) {
            $master = $record->master;

            if (! $master || ! $master->grants_ybhg) {
                return false;
            }

            return $this->resolveTitle(
                $record->selected_prefix_title,
                $master->prefix_title
            ) !== null;
        });

        $prefixes = collect();

        if ($hasYbhg) {
            $prefixes->push('YBhg.');
        }

        $prefixes = $prefixes
            ->concat($honoraryPrefixes)
            ->concat($professionalPrefixes)
            ->values();

        $displayName = trim(
            ($prefixes->isNotEmpty() ? $prefixes->implode(' ') . ' ' : '')
            . trim((string) $staff->name)
        );

        if (! $includeSuffixes) {
            return $displayName;
        }

        $suffixes = $this->suffixes($staff);

        if ($suffixes->isNotEmpty()) {
            $displayName .= ' ' . $suffixes->implode(' ');
        }

        return trim($displayName);
    }

    private function honoraryPrefixes(Staff $staff): Collection
    {
        return $this->uniqueTitles(
            $staff->honoraryTitles
                ->filter(fn ($record) => $record->master !== null)
                ->sortBy(fn ($record) => [
                    $record->master->display_order ?? PHP_INT_MAX,
                    $record->id,
                ])
                ->map(fn ($record) => $this->resolveTitle(
                    $record->selected_prefix_title,
                    $record->master?->prefix_title
                ))
                ->filter()
        );
    }

    private function professionalPrefixes(Staff $staff): Collection
    {
        return $this->uniqueTitles(
            $staff->professionalRecognitions
                ->filter(fn ($record) => $record->master !== null)
                ->sortBy(fn ($record) => [
                    $record->master->prefix_priority ?? PHP_INT_MAX,
                    $record->master->display_order ?? PHP_INT_MAX,
                    $record->id,
                ])
                ->map(fn ($record) => $this->resolveTitle(
                    $record->selected_prefix_title,
                    $record->master?->prefix_title
                ))
                ->filter()
        );
    }

    private function suffixes(Staff $staff): Collection
    {
        $professional = $staff->professionalRecognitions
            ->filter(fn ($record) => $record->master !== null)
            ->sortBy(fn ($record) => [
                $record->master->prefix_priority ?? PHP_INT_MAX,
                $record->master->display_order ?? PHP_INT_MAX,
                $record->id,
            ])
            ->map(fn ($record) => $this->resolveTitle(
                $record->selected_suffix_title,
                $record->master?->suffix_title
            ))
            ->filter();

        $honorary = $staff->honoraryTitles
            ->filter(fn ($record) => $record->master !== null)
            ->sortBy(fn ($record) => [
                $record->master->display_order ?? PHP_INT_MAX,
                $record->id,
            ])
            ->map(fn ($record) => $this->resolveTitle(
                $record->selected_suffix_title,
                $record->master?->suffix_title
            ))
            ->filter();

        return $this->uniqueTitles($professional->concat($honorary));
    }

    private function resolveTitle(?string $selected, ?string $master): ?string
    {
        $selected = trim((string) $selected);

        if ($selected !== '') {
            return $selected;
        }

        $master = trim((string) $master);

        if ($master === '' || $master === '—') {
            return null;
        }

        if (str_contains($master, ' / ')) {
            return null;
        }

        return $master;
    }

    private function uniqueTitles(Collection $titles): Collection
    {
        $seen = [];

        return $titles
            ->filter(function ($title) use (&$seen) {
                $key = mb_strtolower(trim((string) $title));

                if ($key === '' || isset($seen[$key])) {
                    return false;
                }

                $seen[$key] = true;

                return true;
            })
            ->values();
    }
}
