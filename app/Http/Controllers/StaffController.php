<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffServiceRecord;
use App\Models\Department;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Paparkan senarai staf.
     */
    public function index()
    {
        $staff = Staff::with([
            'serviceRecords.department',
            'serviceRecords.unit',
        ])->latest()->paginate(10);

        return view('staff.index', compact('staff'));
    }

    /**
     * Paparkan borang tambah staf.
     */
    

public function create()
{
    $departments = Department::where('is_active', true)
        ->orderBy('name')
        ->get();

    return view('staff.create', compact('departments'));
}
    public function unitsByDepartment(Department $department)

{
    $units = $department->units()
        ->where('is_active', true)
        ->orderBy('name')
        ->get(['id', 'name']);

    return response()->json($units);
}
    /**
     * Simpan staf baru.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        // Maklumat Peribadi
        'name' => ['required', 'string', 'max:255'],
        'ic_no' => ['required', 'string', 'max:20', 'unique:staff,ic_no'],
        'prefix_title' => ['nullable', 'string', 'max:100'],
        'suffix_title' => ['nullable', 'string', 'max:100'],
        'gender' => ['nullable', 'string', 'max:20'],
        'date_of_birth' => ['nullable', 'date'],
        'nationality' => ['nullable', 'string', 'max:100'],
        'birth_state' => ['nullable', 'string', 'max:100'],
        'race' => ['nullable', 'string', 'max:100'],
        'religion' => ['nullable', 'string', 'max:100'],
        'marital_status' => ['nullable', 'string', 'max:50'],
        'former_police_military' => ['nullable', 'boolean'],

        // Maklumat Perkhidmatan
        'staff_no' => ['required', 'string', 'max:50', 'unique:staff_service_records,staff_no'],
        'field_of_study' => ['nullable', 'string', 'max:255'],
        'group' => ['nullable', 'string', 'max:255'],
        'classification' => ['nullable', 'string', 'max:255'],
        'scheme' => ['nullable', 'string', 'max:255'],
        'scheme_category' => ['nullable', 'string', 'max:255'],
        'appointment_type' => ['nullable', 'string', 'max:255'],
        'position' => ['nullable', 'string', 'max:255'],
        'grade' => ['nullable', 'string', 'max:50'],
        'department_id' => ['nullable', 'exists:departments,id'],
        'unit_id' => ['nullable', 'exists:units,id'],
        'service_start_date' => ['nullable', 'date'],
        'service_status' => ['nullable', 'string', 'max:100'],
        'appointment_date' => ['nullable', 'date'],
        'confirmation_date' => ['nullable', 'date'],
    ]);

    // Simpan Maklumat Peribadi
    $staff = Staff::create([
        'name' => $validated['name'],
        'ic_no' => $validated['ic_no'],
        'prefix_title' => $validated['prefix_title'] ?? null,
        'suffix_title' => $validated['suffix_title'] ?? null,
        'gender' => $validated['gender'] ?? null,
        'date_of_birth' => $validated['date_of_birth'] ?? null,
        'nationality' => $validated['nationality'] ?? null,
        'birth_state' => $validated['birth_state'] ?? null,
        'race' => $validated['race'] ?? null,
        'religion' => $validated['religion'] ?? null,
        'marital_status' => $validated['marital_status'] ?? null,
        'former_police_military' => $request->boolean('former_police_military'),
    ]);

    // Simpan Maklumat Perkhidmatan
    StaffServiceRecord::create([
        'staff_id' => $staff->id,
        'staff_no' => $validated['staff_no'],
        'field_of_study' => $validated['field_of_study'] ?? null,
        'group' => $validated['group'] ?? null,
        'classification' => $validated['classification'] ?? null,
        'scheme' => $validated['scheme'] ?? null,
        'scheme_category' => $validated['scheme_category'] ?? null,
        'appointment_type' => $validated['appointment_type'] ?? null,
        'position' => $validated['position'] ?? null,
        'grade' => $validated['grade'] ?? null,
        'department_id' => $validated['department_id'] ?? null,
        'unit_id' => $validated['unit_id'] ?? null,
        'service_start_date' => $validated['service_start_date'] ?? null,
        'service_status' => $validated['service_status'] ?? null,
        'appointment_date' => $validated['appointment_date'] ?? null,
        'confirmation_date' => $validated['confirmation_date'] ?? null,
    ]);

    return redirect()
        ->route('staff.index')
        ->with('success', 'Maklumat staf berjaya disimpan.');
}

    /**
     * Paparkan profil staf.
     */
    public function show(Staff $staff)
    {
        return view('staff.show', compact('staff'));
    }

    /**
     * Paparkan borang edit staf.
     */
    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    /**
     * Kemaskini staf.
     */
    public function update(Request $request, Staff $staff)
    {
        // Kita akan isi kemudian.
    }

    /**
     * Padam staf.
     */
    public function destroy(Staff $staff)
    {
        // Kita akan isi kemudian.
    }
}