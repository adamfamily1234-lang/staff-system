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
use App\Models\Unit;
use App\Models\CompetencyMaster;
use App\Models\ExperienceMaster;
use App\Models\ExperienceMainCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /**
     * Paparkan senarai staf.
     */
    public function index(Request $request)
    {
        $query = Staff::query()
            ->with([
                'serviceRecords.department',
                'serviceRecords.unit',
                'placements.grade',
                'placements.position',
                'placements.department',
                'placements.unit',
            ]);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('ic_no', 'like', '%' . $search . '%')
                    ->orWhereHas('serviceRecords', function ($serviceQuery) use ($search) {
                        $serviceQuery->where('staff_no', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('department_id')) {
            $departmentId = $request->department_id;

            $query->where(function ($q) use ($departmentId) {
                $q->whereHas('placements', function ($placementQuery) use ($departmentId) {
                    $placementQuery
                        ->whereNull('end_date')
                        ->where('department_id', $departmentId);
                })
                ->orWhere(function ($fallbackQuery) use ($departmentId) {
                    $fallbackQuery
                        ->whereDoesntHave('placements', function ($placementQuery) {
                            $placementQuery->whereNull('end_date');
                        })
                        ->whereHas('serviceRecords', function ($serviceQuery) use ($departmentId) {
                            $serviceQuery->where('department_id', $departmentId);
                        });
                });
            });
        }

        if ($request->filled('unit_id')) {
            $unitId = $request->unit_id;

            $query->where(function ($q) use ($unitId) {
                $q->whereHas('placements', function ($placementQuery) use ($unitId) {
                    $placementQuery
                        ->whereNull('end_date')
                        ->where('unit_id', $unitId);
                })
                ->orWhere(function ($fallbackQuery) use ($unitId) {
                    $fallbackQuery
                        ->whereDoesntHave('placements', function ($placementQuery) {
                            $placementQuery->whereNull('end_date');
                        })
                        ->whereHas('serviceRecords', function ($serviceQuery) use ($unitId) {
                            $serviceQuery->where('unit_id', $unitId);
                        });
                });
            });
        }

        if ($request->filled('grade_master_id')) {
            $gradeMasterId = $request->grade_master_id;

            $query->whereHas('placements', function ($placementQuery) use ($gradeMasterId) {
                $placementQuery
                    ->whereNull('end_date')
                    ->where('grade_master_id', $gradeMasterId);
            });
        }

        if ($request->filled('service_status')) {
            $serviceStatus = $request->service_status;

            $query->whereHas('serviceRecords', function ($serviceQuery) use ($serviceStatus) {
                $serviceQuery->where('service_status', $serviceStatus);
            });
        }

        $staff = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $departments = Department::where('is_active', true)
            ->orderBy('name')
            ->get();

        $units = Unit::where('is_active', true)
            ->with('department')
            ->orderBy('name')
            ->get();

        $gradeMasters = GradeMaster::where('is_active', true)
            ->orderByDesc('ranking_order')
            ->get();

        $serviceStatuses = collect([
            'Aktif',
            'Tidak Aktif',
            'Bersara',
            'Berhenti',
            'Tamat Perkhidmatan',
        ]);

        return view('staff.index', compact(
            'staff',
            'departments',
            'units',
            'gradeMasters',
            'serviceStatuses'
        ));
    }

    /**
 * Paparkan senarai kekananan staf.
 */
public function seniority()
{
    $staffList = Staff::with([
        'placements.grade',
        'placements.position',
        'placements.department',
        'placements.unit',
    ])->get();

    $seniorityList = $staffList->map(function ($staff) {

        // Ambil Hakiki sahaja
        $hakikiPlacements = $staff->placements
            ->where('grade_status', 'Hakiki');

        if ($hakikiPlacements->isEmpty()) {
            $staff->seniority_grade = null;
            $staff->seniority_rank = 0;
            $staff->seniority_start_date = null;
            $staff->seniority_placement = null;

            return $staff;
        }

        // Cari ranking gred Hakiki paling tinggi
        $highestRank = $hakikiPlacements->max(function ($placement) {
            return $placement->grade?->ranking_order ?? 0;
        });

        // Ambil semua rekod Hakiki dalam gred tertinggi itu
        $highestGradePlacements = $hakikiPlacements
            ->filter(function ($placement) use ($highestRank) {
                return ($placement->grade?->ranking_order ?? 0)
                    === $highestRank;
            })
            ->sortBy('start_date');

        // Rekod paling awal dalam gred Hakiki tertinggi
        $seniorityPlacement = $highestGradePlacements->first();

        $staff->seniority_grade =
            $seniorityPlacement?->grade?->grade_code;

        $staff->seniority_rank = $highestRank;

        $staff->seniority_start_date =
            $seniorityPlacement?->start_date;

        $staff->seniority_placement =
            $seniorityPlacement;

        return $staff;
    });

    // Susun ranking keseluruhan
    $seniorityList = $seniorityList
        ->sort(function ($a, $b) {

            // 1. Gred lebih tinggi dahulu
            if ($a->seniority_rank !== $b->seniority_rank) {
                return $b->seniority_rank <=> $a->seniority_rank;
            }

            // Staf tiada rekod Hakiki diletakkan bawah
            if (!$a->seniority_start_date && !$b->seniority_start_date) {
                return $a->name <=> $b->name;
            }

            if (!$a->seniority_start_date) {
                return 1;
            }

            if (!$b->seniority_start_date) {
                return -1;
            }

            // 2. Gred sama:
            // tarikh Hakiki lebih awal = lebih kanan
            $dateComparison =
                $a->seniority_start_date
                    <=> $b->seniority_start_date;

            if ($dateComparison !== 0) {
                return $dateComparison;
            }

            // 3. Jika semuanya sama, susun nama
            return $a->name <=> $b->name;
        })
        ->values();

    return view('staff.seniority', compact('seniorityList'));
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
                'in:Aktif,Tidak Aktif,Bersara,Berhenti,Tamat Perkhidmatan'
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
        'competencies.competency',
        'workExperiences.experienceMaster',
        'workExperiences.mainCategory',
        'placements.grade',
        'placements.position',
        'placements.placementType',
        'placements.department',
        'placements.unit',
        'professionalRecognitions.master',
        'honoraryTitles.master',
        'professionalContributions',
        'structuredSkills' => function ($query) {
    $query
        ->where('visibility_scope', 'staff_visible')
        ->with('skill.category.cluster');
},

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

    $competencyMasters = CompetencyMaster::where('is_active', true)
        ->orderBy('discipline')
        ->orderBy('code')
        ->get();

    $experienceMasters = ExperienceMaster::where('is_active', true)
        ->orderBy('field_type')
        ->orderBy('main_system_category')
        ->orderBy('sub_field')
        ->get();

    $experienceMainCategories = ExperienceMainCategory::where('is_active', true)
        ->orderBy('field_type')
        ->orderBy('sort_order')
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

    // =========================================================
    // KEKANANAN HAKIKI
    // =========================================================
    // Rule:
    // 1. Rekod Memangku tidak dikira untuk kekananan.
    // 2. Cari gred Hakiki dengan ranking paling tinggi.
    // 3. Jika terdapat beberapa rekod dalam gred Hakiki yang sama,
    //    guna tarikh mula Hakiki paling awal bagi gred tersebut.
    // 4. Tempoh dalam gred dikira dari tarikh itu sehingga hari ini.

    $hakikiPlacements = $staff->placements
        ->where('grade_status', 'Hakiki');

    $latestHakikiPlacement = null;
    $hakikiStartDate = null;

    if ($hakikiPlacements->isNotEmpty()) {

        // Cari ranking gred Hakiki paling tinggi
        $highestHakikiRank = $hakikiPlacements->max(function ($placement) {
            return $placement->grade?->ranking_order ?? 0;
        });

        // Ambil semua rekod Hakiki dalam gred tertinggi
        $highestGradePlacements = $hakikiPlacements
            ->filter(function ($placement) use ($highestHakikiRank) {
                return ($placement->grade?->ranking_order ?? 0)
                    === $highestHakikiRank;
            })
            ->sortBy('start_date');

        // Rekod paling awal dalam gred Hakiki tertinggi
        $latestHakikiPlacement = $highestGradePlacements->first();

        // Tarikh mula kekananan untuk gred Hakiki tertinggi
        $hakikiStartDate = $latestHakikiPlacement?->start_date;
    }


$currentPlacement = $staff->currentPlacement();


    // =========================================================
    // RINGKASAN / RANKING PENGALAMAN
    // =========================================================
    // Jumlahkan tempoh semua rekod mengikut Kategori Bidang Utama.
    // Kategori manual "Lain-lain" turut dikira menggunakan teks manual.
    $experienceRanking = $staff->workExperiences
        ->map(function ($experience) {
            $start = $experience->start_date;
            $end = $experience->end_date ?? now();

            $categoryName =
                $experience->mainCategory?->name
                ?? $experience->other_main_category
                ?? 'Tidak Dinyatakan';

            return [
                'category' => $categoryName,
                'days' => $start ? $start->diffInDays($end) : 0,
            ];
        })
        ->groupBy('category')
        ->map(function ($items, $category) {
            return [
                'category' => $category,
                'total_days' => $items->sum('days'),
                'record_count' => $items->count(),
            ];
        })
        ->sortByDesc('total_days')
        ->values();

    return view('staff.show', compact(
        'staff',
        'courseFieldTypes',
        'courseMainCategories',
        'courseSubCategories',
        'competencyMasters',
        'experienceMasters',
        'experienceMainCategories',
        'experienceRanking',
        'gradeMasters',
        'positionMasters',
        'placementTypeMasters',
        'departments',
        'latestHakikiPlacement',
        'hakikiStartDate',
        'currentPlacement',
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

        // Simpan rekod penempatan baru
        $staff->placements()->create($validated);

        // Susun semula kronologi penempatan
        $this->rebuildPlacementTimeline($staff);

    return redirect()
        ->route('staff.show', $staff)
        ->with('success', 'Rekod penempatan berjaya disimpan.');
}
    /**
     * Paparkan borang edit staf.
     */
    public function edit(Staff $staff)
    {
        $staff->load([
            'serviceRecords.department',
            'serviceRecords.unit',
        ]);

        $record = $staff->serviceRecords->first();

        $departments = Department::where('is_active', true)
            ->orderBy('name')
            ->get();

        $units = collect();

        if ($record?->department_id) {
            $units = $record->department
                ? $record->department->units()
                    ->where('is_active', true)
                    ->orderBy('name')
                    ->get()
                : collect();
        }

        return view('staff.edit', compact(
            'staff',
            'record',
            'departments',
            'units'
        ));
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
     * Edit rekod pendidikan.
     */
    public function editEducation(Staff $staff, $education)
    {
        $education = $staff->educations()->findOrFail($education);

        return view('staff.educations.edit', compact(
            'staff',
            'education'
        ));
    }

    /**
     * Kemaskini rekod pendidikan.
     */
    public function updateEducation(Request $request, Staff $staff, $education)
    {
        $education = $staff->educations()->findOrFail($education);

        $validated = $request->validate([
            'level' => ['required', 'string', 'max:100'],
            'qualification' => ['required', 'string', 'max:255'],
            'institution' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:2200'],
        ]);

        $education->update($validated);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Maklumat pendidikan berjaya dikemaskini.');
    }

    /**
     * Padam rekod pendidikan.
     */
    public function destroyEducation(Staff $staff, $education)
    {
        $education = $staff->educations()->findOrFail($education);
        $education->delete();

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Rekod pendidikan berjaya dipadam.');
    }

    /**
     * Edit rekod kemahiran.
     */
    public function editSkill(Staff $staff, $skill)
    {
        $skill = $staff->skills()->findOrFail($skill);

        return view('staff.skills.edit', compact(
            'staff',
            'skill'
        ));
    }

    /**
     * Kemaskini rekod kemahiran.
     */
    public function updateSkill(Request $request, Staff $staff, $skill)
    {
        $skill = $staff->skills()->findOrFail($skill);

        $validated = $request->validate([
            'skill' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        $skill->update($validated);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Maklumat kemahiran berjaya dikemaskini.');
    }

    /**
     * Padam rekod kemahiran.
     */
    public function destroySkill(Staff $staff, $skill)
    {
        $skill = $staff->skills()->findOrFail($skill);
        $skill->delete();

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Rekod kemahiran berjaya dipadam.');
    }

    /**
     * Edit rekod kursus.
     */
    public function editCourse(Staff $staff, $course)
    {
        $course = $staff->courses()->findOrFail($course);

        $courseFieldTypes = CourseFieldType::where('is_active', true)
            ->orderBy('name')
            ->get();

        $courseMainCategories = CourseMainCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        $courseSubCategories = CourseSubCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('staff.courses.edit', compact(
            'staff',
            'course',
            'courseFieldTypes',
            'courseMainCategories',
            'courseSubCategories'
        ));
    }

    /**
     * Kemaskini rekod kursus.
     */
    public function updateCourse(Request $request, Staff $staff, $course)
    {
        $course = $staff->courses()->findOrFail($course);

        $validated = $request->validate([
            'course_field_type_id' => ['nullable', 'exists:course_field_types,id'],
            'course_main_category_id' => ['nullable', 'exists:course_main_categories,id'],
            'course_sub_category_id' => ['nullable', 'exists:course_sub_categories,id'],
            'course_name' => ['required', 'string', 'max:255'],
            'organizer' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'venue' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $course->update($validated);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Maklumat kursus berjaya dikemaskini.');
    }

    /**
     * Padam rekod kursus.
     */
    public function destroyCourse(Staff $staff, $course)
    {
        $course = $staff->courses()->findOrFail($course);
        $course->delete();

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Rekod kursus berjaya dipadam.');
    }

    /**
     * Edit rekod anugerah.
     */
    public function editAward(Staff $staff, $award)
    {
        $award = $staff->awards()->findOrFail($award);

        return view('staff.awards.edit', compact(
            'staff',
            'award'
        ));
    }

    /**
     * Kemaskini rekod anugerah.
     */
    public function updateAward(Request $request, Staff $staff, $award)
    {
        $award = $staff->awards()->findOrFail($award);

        $validated = $request->validate([
            'award_name' => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:2200'],
            'level' => [
                'nullable',
                'in:Jabatan,Negeri,Kebangsaan,Antarabangsa,Lain-lain',
            ],
            'notes' => ['nullable', 'string'],
        ]);

        $award->update($validated);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Maklumat anugerah berjaya dikemaskini.');
    }

    /**
     * Padam rekod anugerah.
     */
    public function destroyAward(Staff $staff, $award)
    {
        $award = $staff->awards()->findOrFail($award);
        $award->delete();

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Rekod anugerah berjaya dipadam.');
    }


    /**
     * Simpan rekod kompetensi staf.
     */
    public function storeCompetency(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'competency_master_id' => [
                'required',
                'exists:competency_masters,id',
                Rule::unique('staff_competencies', 'competency_master_id')
                    ->where(function ($query) use ($staff) {
                        return $query->where('staff_id', $staff->id);
                    }),
            ],
            'competency_level' => [
                'required',
                'integer',
                'between:1,4',
            ],
            'achievement_date' => [
                'nullable',
                'date',
            ],
            'certificate_no' => [
                'nullable',
                'string',
                'max:150',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ], [
            'competency_master_id.unique' =>
                'Kompetensi ini telah direkodkan untuk staf ini.',
        ]);

        $staff->competencies()->create($validated);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Maklumat kompetensi berjaya disimpan.');
    }

    /**
     * Paparkan borang edit kompetensi.
     */
    public function editCompetency(Staff $staff, $competency)
    {
        $competency = $staff->competencies()
            ->with('competency')
            ->findOrFail($competency);

        $competencyMasters = CompetencyMaster::where('is_active', true)
            ->orderBy('discipline')
            ->orderBy('code')
            ->get();

        return view('staff.competencies.edit', compact(
            'staff',
            'competency',
            'competencyMasters'
        ));
    }

    /**
     * Kemaskini rekod kompetensi.
     */
    public function updateCompetency(
        Request $request,
        Staff $staff,
        $competency
    ) {
        $competency = $staff->competencies()
            ->findOrFail($competency);

        $validated = $request->validate([
            'competency_master_id' => [
                'required',
                'exists:competency_masters,id',
                Rule::unique('staff_competencies', 'competency_master_id')
                    ->where(function ($query) use ($staff) {
                        return $query->where('staff_id', $staff->id);
                    })
                    ->ignore($competency->id),
            ],
            'competency_level' => [
                'required',
                'integer',
                'between:1,4',
            ],
            'achievement_date' => [
                'nullable',
                'date',
            ],
            'certificate_no' => [
                'nullable',
                'string',
                'max:150',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ], [
            'competency_master_id.unique' =>
                'Kompetensi ini telah direkodkan untuk staf ini.',
        ]);

        $competency->update($validated);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Maklumat kompetensi berjaya dikemaskini.');
    }

    /**
     * Padam rekod kompetensi.
     */
    public function destroyCompetency(Staff $staff, $competency)
    {
        $competency = $staff->competencies()
            ->findOrFail($competency);

        $competency->delete();

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Rekod kompetensi berjaya dipadam.');
    }



    /**
     * Simpan rekod pengalaman kerja staf.
     */
    public function storeWorkExperience(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'field_type' => [
                'required',
                'string',
                'max:150',
                'exists:experience_masters,field_type',
            ],

            'experience_main_category_id' => [
                'nullable',
                'exists:experience_main_categories,id',
                'required_without:other_main_category',
            ],

            'other_main_category' => [
                'nullable',
                'string',
                'max:255',
                'required_without:experience_main_category_id',
            ],

            'system_category' => [
                'nullable',
                'string',
                'max:255',
                'required_without:other_system_category',
            ],

            'other_system_category' => [
                'nullable',
                'string',
                'max:255',
                'required_without:system_category',
            ],

            'experience_master_id' => [
                'nullable',
                'exists:experience_masters,id',
                'required_without:other_sub_field',
            ],

            'other_sub_field' => [
                'nullable',
                'string',
                'max:255',
                'required_without:experience_master_id',
            ],

            'ministry_department' => [
                'nullable',
                'string',
                'max:255',
            ],

            'location_division' => [
                'nullable',
                'string',
                'max:255',
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

        // Pastikan Kategori Bidang Utama memang milik Jenis Bidang dipilih.
        if (!empty($validated['experience_main_category_id'])) {
            $mainCategoryValid = ExperienceMainCategory::whereKey(
                $validated['experience_main_category_id']
            )
                ->where('field_type', $validated['field_type'])
                ->exists();

            if (!$mainCategoryValid) {
                return back()
                    ->withErrors([
                        'experience_main_category_id' =>
                            'Kategori Bidang Utama tidak sepadan dengan Jenis Bidang.',
                    ])
                    ->withInput();
            }

            $validated['other_main_category'] = null;
        } else {
            $validated['experience_main_category_id'] = null;
        }

        // Jika Sistem Utama biasa dipilih, kosongkan manual.
        if (!empty($validated['system_category'])) {
            $systemValid = ExperienceMaster::where(
                'field_type',
                $validated['field_type']
            )
                ->where(
                    'main_system_category',
                    $validated['system_category']
                )
                ->exists();

            if (!$systemValid) {
                return back()
                    ->withErrors([
                        'system_category' =>
                            'Kategori Sistem Utama tidak sepadan dengan Jenis Bidang.',
                    ])
                    ->withInput();
            }

            $validated['other_system_category'] = null;
        } else {
            $validated['system_category'] = null;
        }

        // Jika Sub-Bidang master dipilih, pastikan sepadan dengan Jenis Bidang
        // dan Kategori Sistem Utama biasa yang dipilih.
        if (!empty($validated['experience_master_id'])) {
            $master = ExperienceMaster::find(
                $validated['experience_master_id']
            );

            $masterValid = $master
                && $master->field_type === $validated['field_type']
                && !empty($validated['system_category'])
                && $master->main_system_category ===
                    $validated['system_category'];

            if (!$masterValid) {
                return back()
                    ->withErrors([
                        'experience_master_id' =>
                            'Sistem / Sub-Bidang tidak sepadan dengan pilihan sebelumnya.',
                    ])
                    ->withInput();
            }

            $validated['other_sub_field'] = null;
        } else {
            $validated['experience_master_id'] = null;
        }

        // Field lama tidak digunakan untuk rekod baru.
        $validated['other_experience'] = null;

        $staff->workExperiences()->create($validated);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Pengalaman kerja berjaya disimpan.');
    }

    /**
     * Paparkan borang edit pengalaman kerja.
     */
    public function editWorkExperience(Staff $staff, $workExperience)
    {
        $workExperience = $staff->workExperiences()
            ->with([
                'experienceMaster',
                'mainCategory',
            ])
            ->findOrFail($workExperience);

        $experienceMasters = ExperienceMaster::where('is_active', true)
            ->orderBy('field_type')
            ->orderBy('main_system_category')
            ->orderBy('sub_field')
            ->get();

        $experienceMainCategories = ExperienceMainCategory::where(
            'is_active',
            true
        )
            ->orderBy('field_type')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('staff.work-experiences.edit', compact(
            'staff',
            'workExperience',
            'experienceMasters',
            'experienceMainCategories'
        ));
    }

    /**
     * Kemaskini pengalaman kerja.
     */
    public function updateWorkExperience(
        Request $request,
        Staff $staff,
        $workExperience
    ) {
        $workExperience = $staff->workExperiences()
            ->findOrFail($workExperience);

        $validated = $request->validate([
            'field_type' => [
                'required',
                'string',
                'max:150',
                'exists:experience_masters,field_type',
            ],

            'experience_main_category_id' => [
                'nullable',
                'exists:experience_main_categories,id',
                'required_without:other_main_category',
            ],

            'other_main_category' => [
                'nullable',
                'string',
                'max:255',
                'required_without:experience_main_category_id',
            ],

            'system_category' => [
                'nullable',
                'string',
                'max:255',
                'required_without:other_system_category',
            ],

            'other_system_category' => [
                'nullable',
                'string',
                'max:255',
                'required_without:system_category',
            ],

            'experience_master_id' => [
                'nullable',
                'exists:experience_masters,id',
                'required_without:other_sub_field',
            ],

            'other_sub_field' => [
                'nullable',
                'string',
                'max:255',
                'required_without:experience_master_id',
            ],

            'ministry_department' => [
                'nullable',
                'string',
                'max:255',
            ],

            'location_division' => [
                'nullable',
                'string',
                'max:255',
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

        if (!empty($validated['experience_main_category_id'])) {
            $mainCategoryValid = ExperienceMainCategory::whereKey(
                $validated['experience_main_category_id']
            )
                ->where('field_type', $validated['field_type'])
                ->exists();

            if (!$mainCategoryValid) {
                return back()
                    ->withErrors([
                        'experience_main_category_id' =>
                            'Kategori Bidang Utama tidak sepadan dengan Jenis Bidang.',
                    ])
                    ->withInput();
            }

            $validated['other_main_category'] = null;
        } else {
            $validated['experience_main_category_id'] = null;
        }

        if (!empty($validated['system_category'])) {
            $systemValid = ExperienceMaster::where(
                'field_type',
                $validated['field_type']
            )
                ->where(
                    'main_system_category',
                    $validated['system_category']
                )
                ->exists();

            if (!$systemValid) {
                return back()
                    ->withErrors([
                        'system_category' =>
                            'Kategori Sistem Utama tidak sepadan dengan Jenis Bidang.',
                    ])
                    ->withInput();
            }

            $validated['other_system_category'] = null;
        } else {
            $validated['system_category'] = null;
        }

        if (!empty($validated['experience_master_id'])) {
            $master = ExperienceMaster::find(
                $validated['experience_master_id']
            );

            $masterValid = $master
                && $master->field_type === $validated['field_type']
                && !empty($validated['system_category'])
                && $master->main_system_category ===
                    $validated['system_category'];

            if (!$masterValid) {
                return back()
                    ->withErrors([
                        'experience_master_id' =>
                            'Sistem / Sub-Bidang tidak sepadan dengan pilihan sebelumnya.',
                    ])
                    ->withInput();
            }

            $validated['other_sub_field'] = null;
        } else {
            $validated['experience_master_id'] = null;
        }

        $validated['other_experience'] = null;

        $workExperience->update($validated);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Pengalaman kerja berjaya dikemaskini.');
    }

    /**
     * Padam pengalaman kerja.
     */
    public function destroyWorkExperience(Staff $staff, $workExperience)
    {
        $workExperience = $staff->workExperiences()
            ->findOrFail($workExperience);

        $workExperience->delete();

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Pengalaman kerja berjaya dipadam.');
    }


    /**
     * Edit rekod penempatan / sejarah perkhidmatan.
     */
    public function editPlacement(Staff $staff, $placement)
    {
        $placement = $staff->placements()->findOrFail($placement);

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

        $units = collect();

        if ($placement->department_id) {
            $department = Department::find($placement->department_id);

            if ($department) {
                $units = $department->units()
                    ->where('is_active', true)
                    ->orderBy('name')
                    ->get();
            }
        }

        return view('staff.placements.edit', compact(
            'staff',
            'placement',
            'gradeMasters',
            'positionMasters',
            'placementTypeMasters',
            'departments',
            'units'
        ));
    }

    /**
     * Kemaskini rekod penempatan / sejarah perkhidmatan.
     */
    public function updatePlacement(Request $request, Staff $staff, $placement)
    {
        $placement = $staff->placements()->findOrFail($placement);

        $validated = $request->validate([
            'grade_master_id' => ['required', 'exists:grade_masters,id'],
            'grade_status' => ['required', 'in:Hakiki,Memangku'],
            'position_master_id' => ['nullable', 'exists:position_masters,id'],
            'placement_type_master_id' => ['nullable', 'exists:placement_type_masters,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'unit_id' => ['nullable', 'exists:units,id'],
            'start_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        // end_date tidak diambil daripada borang kerana sistem
        // akan bina semula tarikh tamat berdasarkan kronologi.
        $placement->update($validated);

        $this->rebuildPlacementTimeline($staff);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Rekod penempatan berjaya dikemaskini.');
    }

    /**
     * Padam rekod penempatan / sejarah perkhidmatan.
     */
    public function destroyPlacement(Staff $staff, $placement)
    {
        $placement = $staff->placements()->findOrFail($placement);
        $placement->delete();

        $this->rebuildPlacementTimeline($staff);

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Rekod penempatan berjaya dipadam.');
    }

    /**
     * Kemaskini staf.
     */
    public function update(Request $request, Staff $staff)
    {
        $record = $staff->serviceRecords()->first();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ic_no' => ['required', 'string', 'max:20', 'unique:staff,ic_no,' . $staff->id],
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
            'optional_retirement_year' => ['nullable', 'integer', 'min:1900', 'max:2200'],
            'mandatory_retirement_option' => ['nullable', 'string', 'max:100'],
            'mandatory_retirement_year' => ['nullable', 'integer', 'min:1900', 'max:2200'],
            'latest_property_declaration' => ['nullable', 'date'],
            'photo' => ['nullable', 'string', 'max:255'],

            'staff_no' => ['required', 'string', 'max:50', 'unique:staff_service_records,staff_no,' . ($record?->id ?? 'NULL')],
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
            'service_status' => [
                'nullable',
                'in:Aktif,Tidak Aktif,Bersara,Berhenti,Tamat Perkhidmatan'
            ],
            'appointment_date' => ['nullable', 'date'],
            'confirmation_date' => ['nullable', 'date'],
        ]);

        $staff->update([
            'name' => $validated['name'],
            'ic_no' => $validated['ic_no'],
            'prefix_title' => $validated['prefix_title'] ?? null,
            'suffix_title' => $validated['suffix_title'] ?? null,
            'honours' => $validated['honours'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'nationality' => $validated['nationality'] ?? null,
            'birth_state' => $validated['birth_state'] ?? null,
            'race' => $validated['race'] ?? null,
            'religion' => $validated['religion'] ?? null,
            'marital_status' => $validated['marital_status'] ?? null,
            'former_police_military' => $request->boolean('former_police_military'),
            'housing_type' => $validated['housing_type'] ?? null,
            'housing_loan' => $validated['housing_loan'] ?? null,
            'residential_address' => $validated['residential_address'] ?? null,
            'city' => $validated['city'] ?? null,
            'postcode' => $validated['postcode'] ?? null,
            'state' => $validated['state'] ?? null,
            'mobile_phone' => $validated['mobile_phone'] ?? null,
            'official_email' => $validated['official_email'] ?? null,
            'personal_email' => $validated['personal_email'] ?? null,
            'office_address' => $validated['office_address'] ?? null,
            'office_block' => $validated['office_block'] ?? null,
            'office_phone' => $validated['office_phone'] ?? null,
            'office_fax' => $validated['office_fax'] ?? null,
            'retirement_scheme' => $validated['retirement_scheme'] ?? null,
            'epf_number' => $validated['epf_number'] ?? null,
            'income_tax_number' => $validated['income_tax_number'] ?? null,
            'salary_scheme' => $validated['salary_scheme'] ?? null,
            'optional_retirement_date' => $validated['optional_retirement_date'] ?? null,
            'optional_retirement_year' => $validated['optional_retirement_year'] ?? null,
            'mandatory_retirement_option' => $validated['mandatory_retirement_option'] ?? null,
            'mandatory_retirement_year' => $validated['mandatory_retirement_year'] ?? null,
            'latest_property_declaration' => $validated['latest_property_declaration'] ?? null,
            'photo' => $validated['photo'] ?? null,
        ]);

        $serviceData = [
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
        ];

        if ($record) {
            $record->update($serviceData);
        } else {
            $staff->serviceRecords()->create($serviceData);
        }

        return redirect()
            ->route('staff.show', $staff)
            ->with('success', 'Maklumat staf berjaya dikemaskini.');
    }


    /**
     * Padam staf.
     */
    public function destroy(Staff $staff)
    {
        $staffName = $staff->name;

        $staff->serviceRecords()->delete();
        $staff->educations()->delete();
        $staff->skills()->delete();
        $staff->courses()->delete();
        $staff->awards()->delete();
        $staff->competencies()->delete();
        $staff->workExperiences()->delete();
        $staff->placements()->delete();

        $staff->delete();

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staf ' . $staffName . ' berjaya dipadam.');
    }

    /**
     * Bina semula tarikh tamat penempatan berdasarkan kronologi.
     */
    private function rebuildPlacementTimeline(Staff $staff): void
    {
        $placements = $staff->placements()
            ->orderBy('start_date')
            ->orderBy('id')
            ->get();

        foreach ($placements as $index => $placement) {
            $nextPlacement = $placements->get($index + 1);

            if ($nextPlacement) {
                $nextStartDate = \Carbon\Carbon::parse(
                    $nextPlacement->start_date
                );

                $placement->update([
                    'end_date' => $nextStartDate
                        ->copy()
                        ->subDay(),
                ]);
            } else {
                // Rekod paling terkini sahaja dianggap semasa.
                $placement->update([
                    'end_date' => null,
                ]);
            }
        }
    }

}