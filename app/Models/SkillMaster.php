<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillMaster extends Model
{
    protected $fillable = [
        'skill_category_id',
        'code',
        'name',
        'description',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            SkillCategory::class,
            'skill_category_id'
        );
    }

    public function staffSkills(): HasMany
    {
        return $this->hasMany(
            StaffStructuredSkill::class,
            'skill_master_id'
        );
    }
}
