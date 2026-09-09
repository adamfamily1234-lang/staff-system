<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffCompetency extends Model
{
    protected $fillable = [
        'staff_id',
        'competency_master_id',
        'competency_level',
        'achievement_date',
        'certificate_no',
        'notes',
    ];

    protected $casts = [
        'achievement_date' => 'date',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function competency(): BelongsTo
    {
        return $this->belongsTo(CompetencyMaster::class, 'competency_master_id');
    }
}
