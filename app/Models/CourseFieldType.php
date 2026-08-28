<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseFieldType extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];
}