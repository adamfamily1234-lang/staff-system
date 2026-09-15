<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExperienceMainCategory extends Model
{
    protected $fillable = [
        'field_type',
        'name',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function staffWorkExperiences(): HasMany
    {
        return $this->hasMany(
            StaffWorkExperience::class,
            'experience_main_category_id'
        );
    }
}
