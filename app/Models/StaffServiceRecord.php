<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffServiceRecord extends Model
{
    protected $fillable = [
        'staff_id',
        'staff_no',
        'field_of_study',
        'group',
        'classification',
        'scheme',
        'scheme_category',
        'appointment_type',
        'position',
        'grade',
        'department_id',
        'unit_id',
        'service_start_date',
        'service_status',
        'appointment_date',
        'confirmation_date',
    ];

    protected function casts(): array
    {
        return [
            'service_start_date' => 'date',
            'appointment_date' => 'date',
            'confirmation_date' => 'date',
        ];
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
