<?php

namespace App\Http\Controllers;

use App\Models\HonoraryTitleMaster;
use App\Models\Staff;
use App\Models\StaffHonoraryTitle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HonoraryTitleController extends Controller
{
    public function create(Staff $staff): View
    {
        $masters = HonoraryTitleMaster::query()
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('staff.honorary-titles.create', compact(
            'staff',
            'masters'
        ));
    }

    public function store(Request $request, Staff $staff): RedirectResponse
    {
        $data = $this->validateData($request);

        $master = HonoraryTitleMaster::query()
            ->where('is_active', true)
            ->findOrFail($data['honorary_title_master_id']);

        $duplicate = $staff->honoraryTitles()
            ->where(
                'honorary_title_master_id',
                $master->id
            )
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'honorary_title_master_id' =>
                        'Kurniaan / gelaran kehormat ini telah direkodkan untuk pegawai ini.',
                ]);
        }

        $staff->honoraryTitles()->create([
            'honorary_title_master_id' => $master->id,
            'selected_prefix_title' => $this->normaliseSelectedTitle(
                $data['selected_prefix_title'] ?? null,
                $master->prefix_title
            ),
            'selected_suffix_title' => $this->normaliseSelectedTitle(
                $data['selected_suffix_title'] ?? null,
                $master->suffix_title
            ),
            'warrant_serial_no' => $data['warrant_serial_no'] ?? null,
            'registered_awarded_date' => $data['registered_awarded_date'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Kurniaan / gelaran kehormat berjaya ditambah.');
    }

    public function edit(
        Staff $staff,
        StaffHonoraryTitle $honoraryTitle
    ): View {
        $this->ensureBelongsToStaff($staff, $honoraryTitle);

        $masters = HonoraryTitleMaster::query()
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('staff.honorary-titles.edit', compact(
            'staff',
            'honoraryTitle',
            'masters'
        ));
    }

    public function update(
        Request $request,
        Staff $staff,
        StaffHonoraryTitle $honoraryTitle
    ): RedirectResponse {
        $this->ensureBelongsToStaff($staff, $honoraryTitle);

        $data = $this->validateData($request);

        $master = HonoraryTitleMaster::query()
            ->where('is_active', true)
            ->findOrFail($data['honorary_title_master_id']);

        $duplicate = $staff->honoraryTitles()
            ->where(
                'honorary_title_master_id',
                $master->id
            )
            ->whereKeyNot($honoraryTitle->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'honorary_title_master_id' =>
                        'Kurniaan / gelaran kehormat ini telah direkodkan untuk pegawai ini.',
                ]);
        }

        $honoraryTitle->update([
            'honorary_title_master_id' => $master->id,
            'selected_prefix_title' => $this->normaliseSelectedTitle(
                $data['selected_prefix_title'] ?? null,
                $master->prefix_title
            ),
            'selected_suffix_title' => $this->normaliseSelectedTitle(
                $data['selected_suffix_title'] ?? null,
                $master->suffix_title
            ),
            'warrant_serial_no' => $data['warrant_serial_no'] ?? null,
            'registered_awarded_date' => $data['registered_awarded_date'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Kurniaan / gelaran kehormat berjaya dikemaskini.');
    }

    public function destroy(
        Staff $staff,
        StaffHonoraryTitle $honoraryTitle
    ): RedirectResponse {
        $this->ensureBelongsToStaff($staff, $honoraryTitle);

        $honoraryTitle->delete();

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Kurniaan / gelaran kehormat berjaya dipadam.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'honorary_title_master_id' => [
                'required',
                'integer',
                'exists:honorary_title_masters,id',
            ],
            'selected_prefix_title' => [
                'nullable',
                'string',
                'max:100',
            ],
            'selected_suffix_title' => [
                'nullable',
                'string',
                'max:150',
            ],
            'warrant_serial_no' => [
                'nullable',
                'string',
                'max:150',
            ],
            'registered_awarded_date' => [
                'nullable',
                'date',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);
    }

    private function normaliseSelectedTitle(
        ?string $selected,
        ?string $masterValue
    ): ?string {
        $selected = trim((string) $selected);

        if ($selected !== '') {
            return $selected;
        }

        $masterValue = trim((string) $masterValue);

        if ($masterValue === '' || $masterValue === '—') {
            return null;
        }

        if (str_contains($masterValue, ' / ')) {
            return null;
        }

        return $masterValue;
    }

    private function ensureBelongsToStaff(
        Staff $staff,
        StaffHonoraryTitle $honoraryTitle
    ): void {
        abort_unless(
            (int) $honoraryTitle->staff_id === (int) $staff->id,
            404
        );
    }
}
