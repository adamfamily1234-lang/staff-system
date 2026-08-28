<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffPlacement extends Model
{
    protected $fillable = [
        'staff_id',
        'grade_master_id',
        'grade_status',
        'position_master_id',
        'placement_type_master_id',
        'department_id',
        'unit_id',
        'start_date',
        'end_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(
            GradeMaster::class,
            'grade_master_id'
        );
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(
            PositionMaster::class,
            'position_master_id'
        );
    }

    public function placementType(): BelongsTo
    {
        return $this->belongsTo(
            PlacementTypeMaster::class,
            'placement_type_master_id'
        );
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