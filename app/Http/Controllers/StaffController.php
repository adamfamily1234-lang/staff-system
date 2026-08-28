<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Staff;
use App\Models\StaffServiceRecord;
use App\Models\CourseFieldType;
use App\Models\CourseMainCategory;
use App\Models\CourseSubCategory;
use App\Models\GradeMaster;
use App\Models\PositionMaster;
use App\Models\PlacementTypeMaster;
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


    /**
     * Dapatkan senarai unit berdasarkan bahagian.
     */
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

            // =====================================================
            // 1. MAKLUMAT PERIBADI
            // =====================================================

            'name' => ['required', 'string', 'max:255'],

            'ic_no' => [
                'required',
                'string',
                'max:20',
                'unique:staff,ic_no'
            ],

            'prefix_title' => ['nullable', 'string', 'max:100'],

            'suffix_title' => ['nullable', 'string', 'max:100'],

            'honours' => ['nullable', 'string', 'max:255'],

            'gender' => ['nullable', 'string', 'max:20'],

            'date_of_birth' => ['nullable', 'date'],

            'nationality' => ['nullable', 'string', 'max:100'],

            'birth_state' => ['nullable', 'string', 'max:100'],

            'race' => ['nullable', 'string', 'max:100'],

            'religion' => ['nullable', 'string', 'max:100'],

            'marital_status' => ['nullable', 'string', 'max:50'],

            'former_police_military' => ['nullable', 'boolean'],

            'housing_type' => ['nullable', 'string', 'max:255'],

            'housing_loan' => ['nullable', 'string', 'max:255'],

            'residential_address' => ['nullable', 'string'],

            'city' => ['nullable', 'string', 'max:100'],

            'postcode' => ['nullable', 'string', 'max:20'],

            'state' => ['nullable', 'string', 'max:100'],

            'mobile_phone' => ['nullable', 'string', 'max:30'],

            'official_email' => ['nullable', 'email', 'max:255'],

            'personal_email' => ['nullable', 'email', 'max:255'],

            'office_address' => ['nullable', 'string'],

            'office_block' => ['nullable', 'string', 'max:100'],

            'office_phone' => ['nullable', 'string', 'max:30'],

            'office_fax' => ['nullable', 'string', 'max:30'],

            'retirement_scheme' => ['nullable', 'string', 'max:50'],

            'epf_number' => ['nullable', 'string', 'max:100'],

            'income_tax_number' => ['nullable', 'string', 'max:100'],

            'salary_scheme' => ['nullable', 'string', 'max:100'],

            'optional_retirement_date' => ['nullable', 'date'],

            'optional_retirement_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2200'
            ],

            'mandatory_retirement_option' => [
                'nullable',
                'string',
                'max:100'
            ],

            'mandatory_retirement_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2200'
            ],

            'latest_property_declaration' => [
                'nullable',
                'date'
            ],

            'photo' => [
                'nullable',
                'string',
                'max:255'
            ],


            // =====================================================
            // 2. MAKLUMAT PERKHIDMATAN
            // =====================================================

            'staff_no' => [
                'required',
                'string',
                'max:50',
                'unique:staff_service_records,staff_no'
            ],

            'field_of_study' => [
                'nullable',
                'string',
                'max:255'
            ],

            'group' => [
                'nullable',
                'string',
                'max:255'
            ],

            'classification' => [
                'nullable',
                'string',
                'max:255'
            ],

            'scheme' => [
                'nullable',
                'string',
                'max:255'
            ],

            'scheme_category' => [
                'nullable',
                'string',
                'max:255'
            ],

            'appointment_type' => [
                'nullable',
                'string',
                'max:255'
            ],

            'position' => [
                'nullable',
                'string',
                'max:255'
            ],

            'grade' => [
                'nullable',
                'string',
                'max:50'
            ],

            'department_id' => [
                'nullable',
                'exists:departments,id'
            ],

            'unit_id' => [
                'nullable',
                'exists:units,id'
            ],

            'service_start_date' => [
                'nullable',
                'date'
            ],

            'service_status' => [
                'nullable',
                'string',
                'max:100'
            ],

            'appointment_date' => [
                'nullable',
                'date'
            ],

            'confirmation_date' => [
                'nullable',
                'date'
            ],
        ]);


        // =========================================================
        // SIMPAN MAKLUMAT PERIBADI
        // =========================================================

        $staff = Staff::create([

            'name' => $validated['name'],

            'ic_no' => $validated['ic_no'],

            'prefix_title' =>
                $validated['prefix_title'] ?? null,

            'suffix_title' =>
                $validated['suffix_title'] ?? null,

            'honours' =>
                $validated['honours'] ?? null,

            'gender' =>
                $validated['gender'] ?? null,

            'date_of_birth' =>
                $validated['date_of_birth'] ?? null,

            'nationality' =>
                $validated['nationality'] ?? null,

            'birth_state' =>
                $validated['birth_state'] ?? null,

            'race' =>
                $validated['race'] ?? null,

            'religion' =>
                $validated['religion'] ?? null,

            'marital_status' =>
                $validated['marital_status'] ?? null,

            'former_police_military' =>
                $request->boolean('former_police_military'),

            'housing_type' =>
                $validated['housing_type'] ?? null,

            'housing_loan' =>
                $validated['housing_loan'] ?? null,

            'residential_address' =>
                $validated['residential_address'] ?? null,

            'city' =>
                $validated['city'] ?? null,

            'postcode' =>
                $validated['postcode'] ?? null,

            'state' =>
                $validated['state'] ?? null,

            'mobile_phone' =>
                $validated['mobile_phone'] ?? null,

            'official_email' =>
                $validated['official_email'] ?? null,

            'personal_email' =>
                $validated['personal_email'] ?? null,

            'office_address' =>
                $validated['office_address'] ?? null,

            'office_block' =>
                $validated['office_block'] ?? null,

            'office_phone' =>
                $validated['office_phone'] ?? null,

            'office_fax' =>
                $validated['office_fax'] ?? null,

            'retirement_scheme' =>
                $validated['retirement_scheme'] ?? null,

            'epf_number' =>
                $validated['epf_number'] ?? null,

            'income_tax_number' =>
                $validated['income_tax_number'] ?? null,

            'salary_scheme' =>
                $validated['salary_scheme'] ?? null,

            'optional_retirement_date' =>
                $validated['optional_retirement_date'] ?? null,

            'optional_retirement_year' =>
                $validated['optional_retirement_year'] ?? null,

            'mandatory_retirement_option' =>
                $validated['mandatory_retirement_option'] ?? null,

            'mandatory_retirement_year' =>
                $validated['mandatory_retirement_year'] ?? null,

            'latest_property_declaration' =>
                $validated['latest_property_declaration'] ?? null,

            'photo' =>
                $validated['photo'] ?? null,
        ]);


        // =========================================================
        // SIMPAN MAKLUMAT PERKHIDMATAN
        // =========================================================

        StaffServiceRecord::create([

            'staff_id' => $staff->id,

            'staff_no' =>
                $validated['staff_no'],

            'field_of_study' =>
                $validated['field_of_study'] ?? null,

            'group' =>
                $validated['group'] ?? null,

            'classification' =>
                $validated['classification'] ?? null,

            'scheme' =>
                $validated['scheme'] ?? null,

            'scheme_category' =>
                $validated['scheme_category'] ?? null,

            'appointment_type' =>
                $validated['appointment_type'] ?? null,

            'position' =>
                $validated['position'] ?? null,

            'grade' =>
                $validated['grade'] ?? null,

            'department_id' =>
                $validated['department_id'] ?? null,

            'unit_id' =>
                $validated['unit_id'] ?? null,

            'service_start_date' =>
                $validated['service_start_date'] ?? null,

            'service_status' =>
                $validated['service_status'] ?? null,

            'appointment_date' =>
                $validated['appointment_date'] ?? null,

            'confirmation_date' =>
                $validated['confirmation_date'] ?? null,
        ]);


        // =========================================================
        // SELESAI
        // =========================================================

        return redirect()
            ->route('staff.index')
            ->with(
                'success',
                'Maklumat staf berjaya disimpan.'
            );
    }


/**
 * Paparkan profil staf.
 */
public function show(Staff $staff)
{
    $staff->load([
        'serviceRecords.department',
        'serviceRecords.unit',
        'educations',
        'skills',
        'courses.fieldType',
        'courses.mainCategory',
        'courses.subCategory',
        'awards',
        'placements.grade',
        'placements.position',
        'placements.placementType',
        'placements.department',
        'placements.unit',
    ]);

    $courseFieldTypes = CourseFieldType::where('is_active', true)
        ->orderBy('name')
        ->get();

    $courseMainCategories = CourseMainCategory::where('is_active', true)
        ->orderBy('name')
        ->get();

    $courseSubCategories = CourseSubCategory::where('is_active', true)
        ->orderBy('name')
        ->get();

    $gradeMasters = GradeMaster::where('is_active', true)
        ->orderBy('ranking_order')
        ->get();

    $positionMasters = PositionMaster::where('is_active', true)
        ->orderBy('name')
        ->get();

    $placementTypeMasters = PlacementTypeMaster::where('is_active', true)
        ->orderBy('name')
        ->get();

    $departments = Department::where('is_active', true)
        ->orderBy('name')
        ->get();

    return view('staff.show', compact(
        'staff',
        'courseFieldTypes',
        'courseMainCategories',
        'courseSubCategories',
        'gradeMasters',
        'positionMasters',
        'placementTypeMasters',
        'departments'
    ));
}

public function storePlacement(Request $request, Staff $staff)
{
    $validated = $request->validate([
        'grade_master_id' => [
            'required',
            'exists:grade_masters,id',
        ],

        'grade_status' => [
            'required',
            'in:Hakiki,Memangku',
        ],

        'position_master_id' => [
            'nullable',
            'exists:position_masters,id',
        ],

        'placement_type_master_id' => [
            'nullable',
            'exists:placement_type_masters,id',
        ],

        'department_id' => [
            'nullable',
            'exists:departments,id',
        ],

        'unit_id' => [
            'nullable',
            'exists:units,id',
        ],

        'start_date' => [
            'required',
            'date',
        ],

        'end_date' => [
            'nullable',
            'date',
            'after_or_equal:start_date',
        ],

        'notes' => [
            'nullable',
            'string',
        ],
    ]);

    $staff->placements()->create($validated);

    return redirect()
        ->route('staff.show', $staff)
        ->with('success', 'Rekod penempatan berjaya disimpan.');
}
    /**
     * Paparkan borang edit staf.
     */
    public function edit(Staff $staff)
    {
        return view(
            'staff.edit',
            compact('staff')
        );
    }

/**
 * Simpan rekod pendidikan staf.
 */
public function storeEducation(Request $request, Staff $staff)
{
    $validated = $request->validate([
        'level' => ['required', 'string', 'max:100'],

        'qualification' => [
            'required',
            'string',
            'max:255'
        ],

        'institution' => [
            'nullable',
            'string',
            'max:255'
        ],

        'year' => [
            'nullable',
            'integer',
            'min:1900',
            'max:2200'
        ],
    ]);

    $staff->educations()->create($validated);

    return redirect()
        ->route('staff.show', $staff)
        ->with('success', 'Maklumat pendidikan berjaya disimpan.');
}
/**
 * Simpan rekod kemahiran staf.
 */
public function storeSkill(Request $request, Staff $staff)
{
    $validated = $request->validate([
        'skill' => ['required', 'string', 'max:255'],
        'level' => ['required', 'string', 'max:100'],
        'description' => ['nullable', 'string'],
    ]);

    $staff->skills()->create($validated);

    return redirect()
        ->route('staff.show', $staff)
        ->with('success', 'Maklumat kemahiran berjaya disimpan.');
}
/**
     * Simpan Rekod Kursus Staf.
     */
public function storeCourse(Request $request, Staff $staff)
{
    $validated = $request->validate([
        'course_field_type_id' => [
            'nullable',
            'exists:course_field_types,id',
        ],

        'course_main_category_id' => [
            'nullable',
            'exists:course_main_categories,id',
        ],

        'course_sub_category_id' => [
            'nullable',
            'exists:course_sub_categories,id',
        ],

        'course_name' => [
            'required',
            'string',
            'max:255',
        ],

        'organizer' => [
            'nullable',
            'string',
            'max:255',
        ],

        'start_date' => [
            'nullable',
            'date',
        ],

        'end_date' => [
            'nullable',
            'date',
            'after_or_equal:start_date',
        ],

        'venue' => [
            'nullable',
            'string',
            'max:255',
        ],

        'notes' => [
            'nullable',
            'string',
        ],
    ]);

    $staff->courses()->create($validated);

    return redirect()
        ->route('staff.show', $staff)
        ->with('success', 'Maklumat kursus berjaya disimpan.');
}

/**
     * Simpan Rekod Anugerah Staf.
     */
public function storeAward(Request $request, Staff $staff)
{
    $validated = $request->validate([
        'award_name' => [
            'required',
            'string',
            'max:255',
        ],

        'organization' => [
            'nullable',
            'string',
            'max:255',
        ],

        'year' => [
            'nullable',
            'integer',
            'min:1900',
            'max:2200',
        ],

        'level' => [
            'nullable',
            'in:Jabatan,Negeri,Kebangsaan,Antarabangsa,Lain-lain',
        ],

        'notes' => [
            'nullable',
            'string',
        ],
    ]);

    $staff->awards()->create($validated);

    return redirect()
        ->route('staff.show', $staff)
        ->with('success', 'Maklumat anugerah berjaya disimpan.');
}

    /**
     * Kemaskini staf.
     */
    public function update(Request $request, Staff $staff)
    {
        // Akan kita buat selepas fungsi tambah selesai.
    }


    /**
     * Padam staf.
     */
    public function destroy(Staff $staff)
    {
        // Akan kita buat kemudian.
    }
}