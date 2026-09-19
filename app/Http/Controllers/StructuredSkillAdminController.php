<?php

namespace App\Http\Controllers;

use App\Models\SkillCluster;
use App\Models\Staff;
use App\Models\StaffStructuredSkill;
use App\Services\StructuredSkillAuditService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StructuredSkillAdminController extends Controller
{
    public function __construct(
        private StructuredSkillAuditService $auditService
    ) {
    }

    public function index(Staff $staff)
    {
        $staff->load([
            'structuredSkills.skill.category.cluster',
            'structuredSkills.verifier',
            'structuredSkills.addedBy',
        ]);

        return view(
            'staff.structured-skills-admin.index',
            compact('staff')
        );
    }

    public function create(Staff $staff)
    {
        $clusters = $this->skillTree();

        return view(
            'staff.structured-skills-admin.create',
            compact('staff', 'clusters')
        );
    }

    public function store(Request $request, Staff $staff)
    {
        $validated = $this->validateAdminAdded($request, $staff);

        $validated['declared_level'] = null;
        $validated['declared_at'] = null;

        $validated['verification_status'] = 'verified';
        $validated['added_by_user_id'] = auth()->id();
        $validated['verified_by_user_id'] = auth()->id();
        $validated['verified_at'] = now();

        $skill = $staff->structuredSkills()->create($validated);

        $this->auditService->record(
            $skill,
            'admin_added_verified',
            null,
            $this->auditService->snapshot($skill),
            $validated['verification_notes'] ?? null
        );

        return redirect()
            ->route('staff.structured-skills-admin.index', $staff)
            ->with('success', 'Verified skill berjaya ditambah oleh Admin/Penyelia.');
    }

    public function verifyForm(
        Staff $staff,
        StaffStructuredSkill $structuredSkill
    ) {
        $this->ensureBelongsToStaff($staff, $structuredSkill);

        return view(
            'staff.structured-skills-admin.verify',
            compact('staff', 'structuredSkill')
        );
    }

    public function verify(
        Request $request,
        Staff $staff,
        StaffStructuredSkill $structuredSkill
    ) {
        $this->ensureBelongsToStaff($staff, $structuredSkill);

        $validated = $request->validate([
            'decision' => [
                'required',
                Rule::in(['verified', 'rejected']),
            ],
            'verified_level' => [
                Rule::requiredIf(
                    fn () => $request->input('decision') === 'verified'
                ),
                'nullable',
                'integer',
                Rule::in([1, 2, 3]),
            ],
            'verification_notes' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        $before = $this->auditService->snapshot($structuredSkill);

        if ($validated['decision'] === 'verified') {
            $structuredSkill->update([
                'verification_status' => 'verified',
                'verified_level' => $validated['verified_level'],
                'verified_by_user_id' => auth()->id(),
                'verified_at' => now(),
                'verification_notes' => $validated['verification_notes'],
            ]);

            $action = 'verified';
        } else {
            $structuredSkill->update([
                'verification_status' => 'rejected',
                'verified_level' => null,
                'verified_by_user_id' => auth()->id(),
                'verified_at' => now(),
                'verification_notes' => $validated['verification_notes'],
            ]);

            $action = 'rejected';
        }

        $structuredSkill->refresh();

        $this->auditService->record(
            $structuredSkill,
            $action,
            $before,
            $this->auditService->snapshot($structuredSkill),
            $validated['verification_notes']
        );

        return redirect()
            ->route('staff.structured-skills-admin.index', $staff)
            ->with('success', 'Status verification skill berjaya dikemas kini.');
    }

    public function edit(
        Staff $staff,
        StaffStructuredSkill $structuredSkill
    ) {
        $this->ensureBelongsToStaff($staff, $structuredSkill);

        abort_if(
            $structuredSkill->record_source === 'self_declared',
            403,
            'Self-declared skill perlu diurus melalui flow Verification.'
        );

        $clusters = $this->skillTree();

        return view(
            'staff.structured-skills-admin.edit',
            compact('staff', 'structuredSkill', 'clusters')
        );
    }

    public function update(
        Request $request,
        Staff $staff,
        StaffStructuredSkill $structuredSkill
    ) {
        $this->ensureBelongsToStaff($staff, $structuredSkill);

        abort_if(
            $structuredSkill->record_source === 'self_declared',
            403,
            'Self-declared skill perlu diurus melalui flow Verification.'
        );

        $validated = $this->validateAdminAdded(
            $request,
            $staff,
            $structuredSkill
        );

        $before = $this->auditService->snapshot($structuredSkill);

        $validated['verification_status'] = 'verified';
        $validated['verified_by_user_id'] = auth()->id();
        $validated['verified_at'] = now();

        $structuredSkill->update($validated);
        $structuredSkill->refresh();

        $this->auditService->record(
            $structuredSkill,
            'admin_updated_verified_skill',
            $before,
            $this->auditService->snapshot($structuredSkill),
            $validated['verification_notes'] ?? null
        );

        return redirect()
            ->route('staff.structured-skills-admin.index', $staff)
            ->with('success', 'Admin-added verified skill berjaya dikemas kini.');
    }

    public function destroy(
        Staff $staff,
        StaffStructuredSkill $structuredSkill
    ) {
        $this->ensureBelongsToStaff($staff, $structuredSkill);

        abort_if(
            $structuredSkill->record_source === 'self_declared',
            403,
            'Self-declared skill tidak dipadam melalui flow admin. Gunakan Reject jika perlu.'
        );

        $before = $this->auditService->snapshot($structuredSkill);

        $this->auditService->record(
            $structuredSkill,
            'admin_deleted_skill',
            $before,
            null,
            'Admin/Penyelia memadam rekod admin-added/supervisor-added.'
        );

        $structuredSkill->delete();

        return redirect()
            ->route('staff.structured-skills-admin.index', $staff)
            ->with('success', 'Admin-added skill berjaya dipadam.');
    }

    private function validateAdminAdded(
        Request $request,
        Staff $staff,
        ?StaffStructuredSkill $current = null
    ): array {
        $uniqueSkill = Rule::unique(
            'staff_structured_skills',
            'skill_master_id'
        )->where(
            fn ($query) => $query->where('staff_id', $staff->id)
        );

        if ($current) {
            $uniqueSkill->ignore($current->id);
        }

        return $request->validate([
            'skill_master_id' => [
                'required',
                'integer',
                'exists:skill_masters,id',
                $uniqueSkill,
            ],
            'record_source' => [
                'required',
                Rule::in([
                    'admin_added',
                    'supervisor_added',
                ]),
            ],
            'visibility_scope' => [
                'required',
                Rule::in([
                    'staff_visible',
                    'admin_only',
                ]),
            ],
            'verified_level' => [
                'required',
                'integer',
                Rule::in([1, 2, 3]),
            ],
            'start_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . now()->year,
            ],
            'years_experience' => [
                'nullable',
                'numeric',
                'min:0',
                'max:99.9',
            ],
            'frequency' => [
                'nullable',
                Rule::in([
                    'Jarang',
                    'Berkala',
                    'Kerap',
                    'Sangat Kerap',
                ]),
            ],
            'context' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'evidence_type' => [
                'nullable',
                Rule::in([
                    'Pengalaman sebenar',
                    'Surat lantikan',
                    'Projek / Program',
                    'Portfolio / Hasil kerja',
                    'Sijil',
                    'Pengesahan penyelia',
                    'Lain-lain',
                ]),
            ],
            'evidence_description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'verification_notes' => [
                'required',
                'string',
                'max:5000',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);
    }

    private function ensureBelongsToStaff(
        Staff $staff,
        StaffStructuredSkill $structuredSkill
    ): void {
        abort_unless(
            $structuredSkill->staff_id === $staff->id,
            404
        );
    }

    private function skillTree()
    {
        return SkillCluster::query()
            ->where('is_active', true)
            ->with([
                'categories' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->orderBy('display_order')
                        ->with([
                            'skills' => function ($query) {
                                $query
                                    ->where('is_active', true)
                                    ->orderBy('display_order');
                            },
                        ]);
                },
            ])
            ->orderBy('display_order')
            ->get();
    }
}
