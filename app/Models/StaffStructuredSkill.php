<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaffStructuredSkill extends Model
{
    protected $fillable = [
        'staff_id',
        'skill_master_id',

        'record_source',
        'added_by_user_id',
        'visibility_scope',

        'declared_level',
        'declared_at',

        'start_year',
        'years_experience',
        'frequency',
        'context',

        'evidence_type',
        'evidence_description',

        'verification_status',
        'verified_level',
        'verified_by_user_id',
        'verified_at',
        'verification_notes',

        'notes',
    ];

    protected $casts = [
        'declared_at' => 'datetime',
        'verified_at' => 'datetime',
        'years_experience' => 'decimal:1',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(
            SkillMaster::class,
            'skill_master_id'
        );
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'added_by_user_id'
        );
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'verified_by_user_id'
        );
    }

    public function audits(): HasMany
    {
        return $this->hasMany(
            StaffStructuredSkillAudit::class,
            'staff_structured_skill_id'
        );
    }

    public function scopeStaffVisible(Builder $query): Builder
    {
        return $query->where('visibility_scope', 'staff_visible');
    }

    public function scopeAdminOnly(Builder $query): Builder
    {
        return $query->where('visibility_scope', 'admin_only');
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query
            ->where('verification_status', 'verified')
            ->whereNotNull('verified_level');
    }

    public function getEffectiveLevelAttribute(): ?int
    {
        if (
            $this->verification_status === 'verified'
            && $this->verified_level !== null
        ) {
            return (int) $this->verified_level;
        }

        return $this->declared_level !== null
            ? (int) $this->declared_level
            : null;
    }

    public function getIsVerifiedAttribute(): bool
    {
        return $this->verification_status === 'verified'
            && $this->verified_level !== null;
    }

    public function getIsAdminOnlyAttribute(): bool
    {
        return $this->visibility_scope === 'admin_only';
    }
}
