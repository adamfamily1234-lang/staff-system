<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExperienceMaster extends Model
{
    protected $fillable = [
        'field_type',
        'main_field_category',
        'main_system_category',
        'sub_field',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function staffWorkExperiences(): HasMany
    {
        return $this->hasMany(StaffWorkExperience::class);
    }
}
