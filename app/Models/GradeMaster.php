<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeMaster extends Model
{
    protected $fillable = [
        'grade_code',
        'ranking_order',
        'grade_category',
        'is_active',
    ];
}