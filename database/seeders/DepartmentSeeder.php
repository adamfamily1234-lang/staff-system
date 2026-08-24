<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $engineering = Department::create([
            'name' => 'Jabatan Kejuruteraan',
            'code' => 'JK',
            'is_active' => true,
        ]);

        Unit::create([
            'department_id' => $engineering->id,
            'name' => 'Unit Mekanikal',
            'code' => 'MECH',
            'is_active' => true,
        ]);

        Unit::create([
            'department_id' => $engineering->id,
            'name' => 'Unit Elektrikal',
            'code' => 'ELEC',
            'is_active' => true,
        ]);

        $administration = Department::create([
            'name' => 'Jabatan Pentadbiran',
            'code' => 'JPM',
            'is_active' => true,
        ]);

        Unit::create([
            'department_id' => $administration->id,
            'name' => 'Unit Sumber Manusia',
            'code' => 'HR',
            'is_active' => true,
        ]);
    }
}
