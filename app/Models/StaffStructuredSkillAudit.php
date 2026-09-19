<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffStructuredSkillAudit extends Model
{
    protected $fillable = [
        'staff_structured_skill_id',
        'staff_id',
        'action',
        'actor_user_id',
        'before_data',
        'after_data',
        'notes',
    ];

    protected $casts = [
        'before_data' => 'array',
        'after_data' => 'array',
    ];

    public function structuredSkill(): BelongsTo
    {
        return $this->belongsTo(
            StaffStructuredSkill::class,
            'staff_structured_skill_id'
        );
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }
}
