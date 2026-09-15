<?php

namespace Database\Seeders;

use App\Models\ExperienceMainCategory;
use Illuminate\Database\Seeder;

class ExperienceMainCategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'field_type' => 'Teras Teknikal & Projek',
                'name' => 'Rekabentuk',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'field_type' => 'Teras Teknikal & Projek',
                'name' => 'Pengurusan Projek',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'field_type' => 'Teras Teknikal & Projek',
                'name' => 'Senggara Fasiliti',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'field_type' => 'Teras Teknikal & Projek',
                'name' => 'Testing & Commissioning',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'field_type' => 'Teras Teknikal & Projek',
                'name' => 'Site Supervision',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'field_type' => 'Teras Teknikal & Projek',
                'name' => 'Inspection',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'field_type' => 'Teras Teknikal & Projek',
                'name' => 'Pelaksanaan Projek & Pembinaan',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'field_type' => 'Teras Teknikal & Projek',
                'name' => 'Bahagian Kontrak dan Ukur Bahan',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'field_type' => 'Auditan & Pematuhan',
                'name' => 'Juruaudit Utama',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'field_type' => 'Auditan & Pematuhan',
                'name' => 'Juruaudit Dalaman / Jabatan',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'field_type' => 'Auditan & Pematuhan',
                'name' => 'Penyelaras Audit',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'field_type' => 'Auditan & Pematuhan',
                'name' => 'Auditee',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'field_type' => 'Pengurusan & Pentadbiran',
                'name' => 'Pengerusi / Ketua Pasukan',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'field_type' => 'Pengurusan & Pentadbiran',
                'name' => 'Urus Setia / Penyelaras',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'field_type' => 'Pengurusan & Pentadbiran',
                'name' => 'Ahli Jawatankuasa (AJK)',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'field_type' => 'Pengurusan & Pentadbiran',
                'name' => 'Fasilitator / Penceramah',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'field_type' => 'Sistem & Portfolio Projek',
                'name' => 'Pegawai Pemantau',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'field_type' => 'Sistem & Portfolio Projek',
                'name' => 'Pentadbir Sistem',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            ExperienceMainCategory::updateOrCreate(
                [
                    'field_type' => $item['field_type'],
                    'name' => $item['name'],
                ],
                $item
            );
        }
    }
}
