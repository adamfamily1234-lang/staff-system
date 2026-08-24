<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'name',
        'code',
        'is_active',
    ];

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function serviceRecords(): HasMany
    {
        return $this->hasMany(StaffServiceRecord::class);
    }
}