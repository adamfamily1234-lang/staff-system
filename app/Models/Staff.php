<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $fillable = [
        'name',
        'ic_no',
        'prefix_title',
        'suffix_title',
        'honours',
        'gender',
        'date_of_birth',
        'nationality',
        'birth_state',
        'race',
        'religion',
        'marital_status',
        'former_police_military',
        'housing_type',
        'housing_loan',
        'residential_address',
        'city',
        'postcode',
        'state',
        'mobile_phone',
        'official_email',
        'personal_email',
        'office_address',
        'office_block',
        'office_phone',
        'office_fax',
        'retirement_scheme',
        'epf_number',
        'income_tax_number',
        'salary_scheme',
        'optional_retirement_date',
        'optional_retirement_year',
        'mandatory_retirement_option',
        'mandatory_retirement_year',
        'latest_property_declaration',
        'photo',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'optional_retirement_date' => 'date',
            'latest_property_declaration' => 'date',
            'former_police_military' => 'boolean',
        ];
    }

        /**
     * Rekod perkhidmatan staf.
     */
    public function serviceRecords(): HasMany
    {
        return $this->hasMany(StaffServiceRecord::class);
    }

    /**
     * Rekod pendidikan staf.
     */
    public function educations(): HasMany
    {
        return $this->hasMany(StaffEducation::class);
    }

    /**
     * Rekod kemahiran staf.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(StaffSkill::class);
    }

    /**
     * Rekod Kursus staf.
     */
    public function courses(): HasMany
{
    return $this->hasMany(StaffCourse::class);
}
 /**
     * Rekod Anugerah staf.
     */
public function awards(): HasMany
{
    return $this->hasMany(StaffAward::class);
}
 /**
     * Rekod Penempatan staf.
     */
public function placements(): HasMany
{
    return $this->hasMany(StaffPlacement::class);
}
}