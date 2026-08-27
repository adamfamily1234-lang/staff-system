<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffEducation extends Model
{
    protected $table = 'staff_educations';

    protected $fillable = [
        'staff_id',
        'level',
        'qualification',
        'institution',
        'year',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}