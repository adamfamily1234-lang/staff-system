<?php

namespace Database\Seeders;

use App\Models\CourseSubCategory;
use Illuminate\Database\Seeder;

class CourseSubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Sistem Penyaman Udara',
            'Sistem Pencegahan Kebakaran',
            'Sistem Lif dan Eskalator',
            'Sistem Bekalan Air Dalaman dan Sanitari',
            'Pengurusan & Kejuruteraan Woksyop',
            'Auditan Dalaman SPK (Sistem Pengurusan Kualiti)',
            'Auditan SPAS (Sistem Pengurusan Alam Sekitar)',
            'Auditan SPKKP (Keselamatan & Kesihatan Pekerjaan)',
            'Auditan SPAR (Sistem Pengurusan Antirasuah)',
            'Penilaian & Auditan EKSA Kendiri',
            'Auditan SPT (Sistem Pengurusan Tenaga)',
            'Pelaksanaan Amalan EKSA Kendiri',
            'Kawalan Dokumen, Rekod Bersepadu & Penerbitan Buletin',
            'Penyediaan & Semakan Prosedur Operasi Standard (SOP)',
            'Pelaksanaan Dasar & Objektif Kualiti',
            'Pengurusan & Urus Setia Mesyuarat',
            'Pengurusan Acara & Program Rasmi',
            'Perancangan Strategik & Pelan Bisnes',
            'Penyelarasan Takwim Cawangan',
            'Pengurusan & Kemas Kini myPortfolio',
            'Penyelarasan Latihan & Kursus',
            'Pengurusan & Penilaian Kompetensi',
            'Pengurusan Inovasi & Kumpulan Inovatif dan Kreatif (KIK)',
            'Pengurusan Tatatertib & Disiplin',
            'Penyelarasan Permohonan Projek (RMK / Rolling Plan)',
            'Pemantauan Prestasi Portfolio (SKALA / SPP II / MyProjek)',
            'Pemantauan & Pelaporan Peruntukan Kewangan Projek',
            'Penyelarasan Mesyuarat Pemantauan Projek (MTPK / Kajian Semula)',
        ];

        foreach ($items as $item) {
            CourseSubCategory::updateOrCreate(
                ['name' => $item],
                ['is_active' => true]
            );
        }
    }
}