<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,

            GradeMasterSeeder::class,
            PositionMasterSeeder::class,
            PlacementTypeMasterSeeder::class,

            CourseFieldTypeSeeder::class,
            CourseMainCategorySeeder::class,
            CourseSubCategorySeeder::class,

            StaffSeeder::class,
        ]);
    }
}