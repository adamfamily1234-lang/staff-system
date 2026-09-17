<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalRecognitionMaster;
use App\Models\Staff;
use App\Models\StaffProfessionalRecognition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfessionalRecognitionController extends Controller
{
    public function create(Staff $staff): View
    {
        $masters = ProfessionalRecognitionMaster::query()
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('staff.professional-recognitions.create', compact(
            'staff',
            'masters'
        ));
    }

    public function store(Request $request, Staff $staff): RedirectResponse
    {
        $data = $this->validateData($request);

        $master = ProfessionalRecognitionMaster::query()
            ->where('is_active', true)
            ->findOrFail($data['professional_recognition_master_id']);

        $duplicate = $staff->professionalRecognitions()
            ->where(
                'professional_recognition_master_id',
                $master->id
            )
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'professional_recognition_master_id' =>
                        'Pengiktirafan profesional ini telah direkodkan untuk pegawai ini.',
                ]);
        }

        $staff->professionalRecognitions()->create([
            'professional_recognition_master_id' => $master->id,
            'selected_prefix_title' => $this->normaliseSelectedTitle(
                $data['selected_prefix_title'] ?? null,
                $master->prefix_title
            ),
            'selected_suffix_title' => $this->normaliseSelectedTitle(
                $data['selected_suffix_title'] ?? null,
                $master->suffix_title
            ),
            'registration_no' => $data['registration_no'] ?? null,
            'registered_awarded_date' => $data['registered_awarded_date'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Pengiktirafan profesional berjaya ditambah.');
    }

    public function edit(
        Staff $staff,
        StaffProfessionalRecognition $professionalRecognition
    ): View {
        $this->ensureBelongsToStaff($staff, $professionalRecognition);

        $masters = ProfessionalRecognitionMaster::query()
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('staff.professional-recognitions.edit', compact(
            'staff',
            'professionalRecognition',
            'masters'
        ));
    }

    public function update(
        Request $request,
        Staff $staff,
        StaffProfessionalRecognition $professionalRecognition
    ): RedirectResponse {
        $this->ensureBelongsToStaff($staff, $professionalRecognition);

        $data = $this->validateData($request);

        $master = ProfessionalRecognitionMaster::query()
            ->where('is_active', true)
            ->findOrFail($data['professional_recognition_master_id']);

        $duplicate = $staff->professionalRecognitions()
            ->where(
                'professional_recognition_master_id',
                $master->id
            )
            ->whereKeyNot($professionalRecognition->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'professional_recognition_master_id' =>
                        'Pengiktirafan profesional ini telah direkodkan untuk pegawai ini.',
                ]);
        }

        $professionalRecognition->update([
            'professional_recognition_master_id' => $master->id,
            'selected_prefix_title' => $this->normaliseSelectedTitle(
                $data['selected_prefix_title'] ?? null,
                $master->prefix_title
            ),
            'selected_suffix_title' => $this->normaliseSelectedTitle(
                $data['selected_suffix_title'] ?? null,
                $master->suffix_title
            ),
            'registration_no' => $data['registration_no'] ?? null,
            'registered_awarded_date' => $data['registered_awarded_date'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Pengiktirafan profesional berjaya dikemaskini.');
    }

    public function destroy(
        Staff $staff,
        StaffProfessionalRecognition $professionalRecognition
    ): RedirectResponse {
        $this->ensureBelongsToStaff($staff, $professionalRecognition);

        $professionalRecognition->delete();

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Pengiktirafan profesional berjaya dipadam.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'professional_recognition_master_id' => [
                'required',
                'integer',
                'exists:professional_recognition_masters,id',
            ],
            'selected_prefix_title' => [
                'nullable',
                'string',
                'max:100',
            ],
            'selected_suffix_title' => [
                'nullable',
                'string',
                'max:150',
            ],
            'registration_no' => [
                'nullable',
                'string',
                'max:150',
            ],
            'registered_awarded_date' => [
                'nullable',
                'date',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);
    }

    private function normaliseSelectedTitle(
        ?string $selected,
        ?string $masterValue
    ): ?string {
        $selected = trim((string) $selected);

        if ($selected !== '') {
            return $selected;
        }

        $masterValue = trim((string) $masterValue);

        if ($masterValue === '' || $masterValue === '—') {
            return null;
        }

        // Jika master ada beberapa pilihan seperti "Pmr. / TPr.",
        // jangan simpan gabungan itu sebagai title sebenar.
        if (str_contains($masterValue, ' / ')) {
            return null;
        }

        return $masterValue;
    }

    private function ensureBelongsToStaff(
        Staff $staff,
        StaffProfessionalRecognition $professionalRecognition
    ): void {
        abort_unless(
            (int) $professionalRecognition->staff_id === (int) $staff->id,
            404
        );
    }
}
