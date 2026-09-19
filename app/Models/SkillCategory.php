<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillCategory extends Model
{
    protected $fillable = [
        'skill_cluster_id',
        'code',
        'name',
        'description',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(
            SkillCluster::class,
            'skill_cluster_id'
        );
    }

    public function skills(): HasMany
    {
        return $this->hasMany(SkillMaster::class);
    }
}
