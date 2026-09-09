<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompetencyMaster extends Model
{
    protected $fillable = [
        'discipline',
        'code',
        'domain',
        'competency_title',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function staffCompetencies(): HasMany
    {
        return $this->hasMany(StaffCompetency::class);
    }
}
