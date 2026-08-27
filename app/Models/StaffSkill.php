<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffSkill extends Model
{
    protected $table = 'staff_skills';

    protected $fillable = [
        'staff_id',
        'skill',
        'level',
        'description',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}