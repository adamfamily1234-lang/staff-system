<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMainCategory extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];
}