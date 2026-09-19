<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffProfessionalContribution;
use Illuminate\Http\Request;

class ProfessionalContributionController extends Controller
{
    public function create(Staff $staff)
    {
        return view('staff.professional-contributions.create', compact('staff'));
    }

    public function store(Request $request, Staff $staff)
    {
        $staff->professionalContributions()->create($this->validateData($request));

        return redirect()->route('staff.show', $staff)
            ->with('success', 'Sumbangan / penglibatan profesional berjaya ditambah.');
    }

    public function edit(Staff $staff, StaffProfessionalContribution $professionalContribution)
    {
        $this->ensureBelongsToStaff($staff, $professionalContribution);

        return view('staff.professional-contributions.edit',
            compact('staff', 'professionalContribution'));
    }

    public function update(Request $request, Staff $staff, StaffProfessionalContribution $professionalContribution)
    {
        $this->ensureBelongsToStaff($staff, $professionalContribution);
        $professionalContribution->update($this->validateData($request));

        return redirect()->route('staff.show', $staff)
            ->with('success', 'Sumbangan / penglibatan profesional berjaya dikemas kini.');
    }

    public function destroy(Staff $staff, StaffProfessionalContribution $professionalContribution)
    {
        $this->ensureBelongsToStaff($staff, $professionalContribution);
        $professionalContribution->delete();

        return redirect()->route('staff.show', $staff)
            ->with('success', 'Sumbangan / penglibatan profesional berjaya dipadam.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'activity_type' => ['nullable','string','max:255'],
            'activity_name' => ['required','string','max:255'],
            'role' => ['nullable','string','max:255'],
            'organization' => ['nullable','string','max:255'],
            'level' => ['nullable','string','max:100'],
            'start_date' => ['nullable','date'],
            'end_date' => ['nullable','date','after_or_equal:start_date'],
            'reference_no' => ['nullable','string','max:255'],
            'notes' => ['nullable','string'],
        ]);
    }

    private function ensureBelongsToStaff(Staff $staff, StaffProfessionalContribution $professionalContribution): void
    {
        abort_unless($professionalContribution->staff_id === $staff->id, 404);
    }
}
