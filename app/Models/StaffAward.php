<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffAward extends Model
{
    protected $fillable = [
        'staff_id',
        'award_name',
        'organization',
        'year',
        'level',
        'notes',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}