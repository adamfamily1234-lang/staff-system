<?php

namespace App\Models\Concerns;

use App\Services\StaffTitleService;

trait HasFormattedStaffName
{
    public function getDisplayNameAttribute(): string
    {
        return app(StaffTitleService::class)->format($this);
    }

    public function getDisplayNameWithoutSuffixAttribute(): string
    {
        return app(StaffTitleService::class)->format($this, false);
    }
}
