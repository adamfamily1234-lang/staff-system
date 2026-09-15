<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffWorkExperience extends Model
{
    protected $fillable = [
        'staff_id',
        'experience_master_id',
        'experience_main_category_id',

        'field_type',
        'system_category',

        'other_main_category',
        'other_system_category',
        'other_sub_field',

        // Legacy field - kept for old records.
        'other_experience',

        'ministry_department',
        'location_division',
        'start_date',
        'end_date',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function experienceMaster(): BelongsTo
    {
        return $this->belongsTo(
            ExperienceMaster::class,
            'experience_master_id'
        );
    }

    public function mainCategory(): BelongsTo
    {
        return $this->belongsTo(
            ExperienceMainCategory::class,
            'experience_main_category_id'
        );
    }
}
