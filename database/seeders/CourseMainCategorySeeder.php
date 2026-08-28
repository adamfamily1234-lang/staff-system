<?php

namespace Database\Seeders;

use App\Models\CourseMainCategory;
use Illuminate\Database\Seeder;

class CourseMainCategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'ACMV (Air Conditioning & Mechanical Ventilation)',
            'Kebakaran',
            'Lif',
            'Plumbing',
            'Pengurusan Aset Loji, Jentera & Kenderaan (Woksyop)',
            'Vehicles (Kenderaan)',
            'Kejuruteraan Kuari dan Loji',
            'Inspection & Evaluation of vehicles / machineries / equipment',
            'Maintenance of vehicles & construction machinery',
            'Quarry Operation, Maintenance and Road Surfacing',
            'Kelestarian Sistem Mekanikal',
            'Sistem Pengurusan Tenaga',
            'Sistem Kecekapan Penggunaan Air',
            'Kawalan Bunyi dan Getaran',
            'Kejuruteraan Sistem Perubatan',
            'Mechanical Services Specialist',
            'Sistem Automasi Bangunan',
            'Maintenance of mechanical systems in buildings',
            'Inspection & Evaluation of Mechanical System in Buildings',
            'Kejuruteraan Forensik Mekanikal',
            'Design of Air-Conditioning & Mechanical Ventilation System',
            'Design of Fire Fighting System',
            'Design of Lift, Dumbwaiter & Escalator System',
            'Internal Cold Water, Sanitary Plumbing System & Pumping System',
            'Design of Laboratory & Medical Equipment / Piped Gas System',
            'Design of Miscellaneous Mechanical Services',
            'Building Management System Design',
            'Quarry Design',
            'Building Information Modeling',
            'Mechanical Drawing-Autocad',
            'AI In Mechanical Design',
            'D&B Project Implementation Pre Contract (Mechanical)',
            'In-House Project Implementation (Mechanical consultant)',
            'Consultancy Services (Mechanical)',
            'Mechanical Tender Documentation and Evaluation',
            'Site supervision for mechanical project',
            'Testing & Commissioning of mechanical system',
            'Auditan',
            'Pengurusan Kualiti',
            'Pentadbiran & Pengurusan Korporat',
            'Latihan & Kompetensi',
            'Pengurusan Portfolio Projek',
        ];

        foreach ($items as $item) {
            CourseMainCategory::updateOrCreate(
                ['name' => $item],
                ['is_active' => true]
            );
        }
    }
}