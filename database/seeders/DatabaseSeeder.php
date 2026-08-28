<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            StaffSeeder::class,

            CourseFieldTypeSeeder::class,
            CourseMainCategorySeeder::class,
            CourseSubCategorySeeder::class,
        ]);
    }
}