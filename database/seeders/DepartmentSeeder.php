<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $engineering = Department::updateOrCreate(
            ['code' => 'JK'],
            [
                'name' => 'Jabatan Kejuruteraan',
                'is_active' => true,
            ]
        );

        Unit::updateOrCreate(
            ['code' => 'MECH'],
            [
                'department_id' => $engineering->id,
                'name' => 'Unit Mekanikal',
                'is_active' => true,
            ]
        );

        Unit::updateOrCreate(
            ['code' => 'ELEC'],
            [
                'department_id' => $engineering->id,
                'name' => 'Unit Elektrikal',
                'is_active' => true,
            ]
        );

        $admin = Department::updateOrCreate(
            ['code' => 'JPM'],
            [
                'name' => 'Jabatan Pentadbiran',
                'is_active' => true,
            ]
        );

        Unit::updateOrCreate(
            ['code' => 'HR'],
            [
                'department_id' => $admin->id,
                'name' => 'Unit Sumber Manusia',
                'is_active' => true,
            ]
        );
    }
}