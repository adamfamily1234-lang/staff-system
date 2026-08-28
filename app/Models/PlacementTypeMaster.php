<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlacementTypeMaster extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];
}