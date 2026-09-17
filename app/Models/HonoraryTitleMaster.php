<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HonoraryTitleMaster extends Model
{
    protected $fillable = [
        'issuer_category',
        'issuer',
        'scope_level',
        'award_name',
        'prefix_title',
        'suffix_title',
        'grants_ybhg',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'grants_ybhg' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function staffTitles(): HasMany
    {
        return $this->hasMany(StaffHonoraryTitle::class);
    }
}
