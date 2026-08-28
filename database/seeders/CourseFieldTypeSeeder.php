<?php

namespace Database\Seeders;

use App\Models\CourseFieldType;
use Illuminate\Database\Seeder;

class CourseFieldTypeSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Teras Teknikal & Projek',
            'Kelestarian & Kepakaran Khusus (Sustainability & Advisory)',
            'Pengurusan Fasiliti Bangunan & Forensik (Facility Management)',
            'Rekabentuk (Design) & Teknologi Pemodelan',
            'Pelaksanaan Projek (Project Delivery) & Pengurusan Kontrak',
            'Penyeliaan Tapak (Site Supervision) & Pengujian',
            'Auditan & Pematuhan',
            'Pengurusan & Pentadbiran',
            'Sistem & Portfolio Projek',
        ];

        foreach ($items as $item) {
            CourseFieldType::updateOrCreate(
                ['name' => $item],
                ['is_active' => true]
            );
        }
    }
}