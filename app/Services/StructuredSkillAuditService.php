<?php

namespace App\Services;

use App\Models\StaffStructuredSkill;
use App\Models\StaffStructuredSkillAudit;

class StructuredSkillAuditService
{
    public function record(
        StaffStructuredSkill $skill,
        string $action,
        ?array $before = null,
        ?array $after = null,
        ?string $notes = null
    ): StaffStructuredSkillAudit {
        return StaffStructuredSkillAudit::create([
            'staff_structured_skill_id' => $skill->exists ? $skill->id : null,
            'staff_id' => $skill->staff_id,
            'action' => $action,
            'actor_user_id' => auth()->id(),
            'before_data' => $before,
            'after_data' => $after,
            'notes' => $notes,
        ]);
    }

    public function snapshot(StaffStructuredSkill $skill): array
    {
        return [
            'id' => $skill->id,
            'staff_id' => $skill->staff_id,
            'skill_master_id' => $skill->skill_master_id,
            'record_source' => $skill->record_source,
            'visibility_scope' => $skill->visibility_scope,
            'declared_level' => $skill->declared_level,
            'declared_at' => optional($skill->declared_at)?->toDateTimeString(),
            'start_year' => $skill->start_year,
            'years_experience' => $skill->years_experience,
            'frequency' => $skill->frequency,
            'context' => $skill->context,
            'evidence_type' => $skill->evidence_type,
            'evidence_description' => $skill->evidence_description,
            'verification_status' => $skill->verification_status,
            'verified_level' => $skill->verified_level,
            'verified_by_user_id' => $skill->verified_by_user_id,
            'verified_at' => optional($skill->verified_at)?->toDateTimeString(),
            'verification_notes' => $skill->verification_notes,
            'notes' => $skill->notes,
        ];
    }
}
