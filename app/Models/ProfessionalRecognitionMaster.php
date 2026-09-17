<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfessionalRecognitionMaster extends Model
{
    protected $fillable = [
        'regulator_category',
        'issuer',
        'registration_scope',
        'professional_level',
        'prefix_title',
        'suffix_title',
        'prefix_priority',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function staffRecognitions(): HasMany
    {
        return $this->hasMany(StaffProfessionalRecognition::class);
    }
}
