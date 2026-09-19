<?php

namespace App\Http\Controllers;

use App\Models\SkillCluster;
use App\Models\Staff;
use App\Models\StaffStructuredSkill;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StructuredSkillController extends Controller
{
    public function create(Staff $staff)
    {
        $clusters = $this->skillTree();

        return view(
            'staff.structured-skills.create',
            compact('staff', 'clusters')
        );
    }

    public function store(Request $request, Staff $staff)
    {
        $validated = $this->validateData($request, $staff);

        // SELF-DECLARED FLOW:
        // Verification/admin-only fields are NEVER accepted from the form.
        $validated['record_source'] = 'self_declared';
        $validated['visibility_scope'] = 'staff_visible';
        $validated['verification_status'] = 'self_declared';
        $validated['verified_level'] = null;
        $validated['verified_by_user_id'] = null;
        $validated['verified_at'] = null;
        $validated['verification_notes'] = null;
        $validated['declared_at'] = now();

        // Bila login/role siap nanti, set added_by_user_id = auth()->id().
        $validated['added_by_user_id'] = auth()->id();

        $staff->structuredSkills()->create($validated);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Structured skill berjaya ditambah sebagai self-declared.');
    }

    public function edit(
        Staff $staff,
        StaffStructuredSkill $structuredSkill
    ) {
        $this->ensureBelongsToStaff($staff, $structuredSkill);

        // Step 2 hanya untuk rekod staff-visible self-declared.
        abort_unless(
            $structuredSkill->record_source === 'self_declared'
            && $structuredSkill->visibility_scope === 'staff_visible',
            403
        );

        $clusters = $this->skillTree();

        return view(
            'staff.structured-skills.edit',
            compact('staff', 'structuredSkill', 'clusters')
        );
    }


    public function update(
        Request $request,
        Staff $staff,
        StaffStructuredSkill $structuredSkill
    ) {
        $this->ensureBelongsToStaff($staff, $structuredSkill);

        abort_unless(
            $structuredSkill->record_source === 'self_declared'
            && $structuredSkill->visibility_scope === 'staff_visible',
            403
        );

        $validated = $this->validateData(
            $request,
            $staff,
            $structuredSkill
        );

        // Jangan benarkan edit self-declared mengubah verification.
        $validated['declared_at'] = now();

        $validated['verification_status'] = 'self_declared';
        $validated['verified_level'] = null;
        $validated['verified_by_user_id'] = null;
        $validated['verified_at'] = null;
        $validated['verification_notes'] = null;

        $structuredSkill->update($validated);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Structured skill self-declared berjaya dikemas kini.');
    }

    public function destroy(
        Staff $staff,
        StaffStructuredSkill $structuredSkill
    ) {
        $this->ensureBelongsToStaff($staff, $structuredSkill);

        // Untuk Step 2, hanya self-declared staff-visible boleh dipadam
        // melalui flow ini.
        abort_unless(
            $structuredSkill->record_source === 'self_declared'
            && $structuredSkill->visibility_scope === 'staff_visible',
            403
        );

        $structuredSkill->delete();

        abort_if(
    $structuredSkill->verification_status === 'verified',
    403,
    'Verified skill tidak boleh dipadam oleh staff. Sila rujuk Admin/Penyelia.'
);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Structured skill self-declared berjaya dipadam.');
    }

    private function validateData(
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
            'declared_level' => [
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
