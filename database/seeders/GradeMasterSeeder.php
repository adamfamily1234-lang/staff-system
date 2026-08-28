<?php

namespace Database\Seeders;

use App\Models\GradeMaster;
use Illuminate\Database\Seeder;

class GradeMasterSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            [
                'grade_code' => 'JA5',
                'ranking_order' => 1,
                'grade_category' => 'Kumpulan Pelaksana',
            ],
            [
                'grade_code' => 'JA6',
                'ranking_order' => 2,
                'grade_category' => 'Kumpulan Pelaksana',
            ],
            [
                'grade_code' => 'JA7',
                'ranking_order' => 3,
                'grade_category' => 'Kumpulan Pelaksana',
            ],
            [
                'grade_code' => 'JA8',
                'ranking_order' => 4,
                'grade_category' => 'Kumpulan Pelaksana',
            ],
            [
                'grade_code' => 'J9',
                'ranking_order' => 5,
                'grade_category' => 'Kumpulan Pengurusan dan Profesional',
            ],
            [
                'grade_code' => 'J10',
                'ranking_order' => 6,
                'grade_category' => 'Kumpulan Pengurusan dan Profesional',
            ],
            [
                'grade_code' => 'J12',
                'ranking_order' => 7,
                'grade_category' => 'Kumpulan Pengurusan dan Profesional',
            ],
            [
                'grade_code' => 'J13',
                'ranking_order' => 8,
                'grade_category' => 'Kumpulan Pengurusan dan Profesional',
            ],
            [
                'grade_code' => 'J14',
                'ranking_order' => 9,
                'grade_category' => 'Kumpulan Pengurusan dan Profesional',
            ],
            [
                'grade_code' => 'Jusa C',
                'ranking_order' => 10,
                'grade_category' => 'Kumpulan Pengurusan Tertinggi',
            ],
            [
                'grade_code' => 'Jusa B',
                'ranking_order' => 11,
                'grade_category' => 'Kumpulan Pengurusan Tertinggi',
            ],
            [
                'grade_code' => 'Jusa A',
                'ranking_order' => 12,
                'grade_category' => 'Kumpulan Pengurusan Tertinggi',
            ],
        ];

        foreach ($grades as $grade) {
            GradeMaster::updateOrCreate(
                ['grade_code' => $grade['grade_code']],
                [
                    'ranking_order' => $grade['ranking_order'],
                    'grade_category' => $grade['grade_category'],
                    'is_active' => true,
                ]
            );
        }
    }
}