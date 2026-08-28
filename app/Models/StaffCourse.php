<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffCourse extends Model
{
    protected $fillable = [
        'staff_id',
        'course_field_type_id',
        'course_main_category_id',
        'course_sub_category_id',
        'course_name',
        'organizer',
        'start_date',
        'end_date',
        'venue',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function fieldType(): BelongsTo
    {
        return $this->belongsTo(
            CourseFieldType::class,
            'course_field_type_id'
        );
    }

    public function mainCategory(): BelongsTo
    {
        return $this->belongsTo(
            CourseMainCategory::class,
            'course_main_category_id'
        );
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(
            CourseSubCategory::class,
            'course_sub_category_id'
        );
    }
}