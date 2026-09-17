<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffProfessionalRecognition extends Model
{
    protected $fillable = [
        'staff_id',
        'professional_recognition_master_id',
        'selected_prefix_title',
        'selected_suffix_title',
        'registration_no',
        'registered_awarded_date',
        'notes',
    ];

    protected $casts = [
        'registered_awarded_date' => 'date',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function master(): BelongsTo
    {
        return $this->belongsTo(
            ProfessionalRecognitionMaster::class,
            'professional_recognition_master_id'
        );
    }
}