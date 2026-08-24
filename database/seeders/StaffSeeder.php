<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Staff;
use App\Models\StaffServiceRecord;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $department = Department::where('code', 'JK')->first();
        $unit = Unit::where('code', 'MECH')->first();

        $staff = Staff::create([
            'name' => 'Ahmad bin Abdullah',
            'ic_no' => '850101-01-1234',
            'gender' => 'Lelaki',
            'date_of_birth' => '1985-01-01',
            'nationality' => 'Malaysia',
            'birth_state' => 'Selangor',
            'race' => 'Melayu',
            'religion' => 'Islam',
            'marital_status' => 'Berkahwin',
            'former_police_military' => false,
            'mobile_phone' => '012-3456789',
            'official_email' => 'ahmad@example.com',
            'personal_email' => 'ahmad.personal@example.com',
            'retirement_scheme' => 'Pencen',
            'salary_scheme' => 'SSPA',
        ]);

        StaffServiceRecord::create([
            'staff_id' => $staff->id,
            'staff_no' => 'ST001',
            'field_of_study' => 'Kejuruteraan Mekanikal',
            'group' => 'Pengurusan dan Profesional',
            'classification' => 'Kejuruteraan',
            'scheme' => 'Kejuruteraan',
            'scheme_category' => 'Teknikal',
            'appointment_type' => 'Tetap',
            'position' => 'Pegawai Teknologi',
            'grade' => 'F41',
            'department_id' => $department->id,
            'unit_id' => $unit->id,
            'service_start_date' => '2015-01-01',
            'service_status' => 'Aktif',
            'appointment_date' => '2015-01-01',
            'confirmation_date' => '2017-01-01',
        ]);
    }
}
