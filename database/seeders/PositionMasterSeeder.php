<?php

namespace Database\Seeders;

use App\Models\PositionMaster;
use Illuminate\Database\Seeder;

class PositionMasterSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            'Penolong Jurutera',
            'Penolong Jurutera Kanan',
            'Penolong Jurutera Tertinggi',
            'Jurutera Mekanikal',
            'Jurutera Mekanikal Kanan',
            'Jurutera Mekanikal Penguasa',
            'Jurutera Mekanikal Penguasa Kanan',
            'Pengarah Kanan',
            'Pengarah Khidmat Pakar',
            'Pengarah Rekabentuk',
            'Ketua Jurutera Mekanikal Negeri',
            'Ketua Jurutera Mekanikal',
            'Jurutera Mekanikal Negeri',
        ];

        foreach ($positions as $position) {
            PositionMaster::updateOrCreate(
                ['name' => $position],
                ['is_active' => true]
            );
        }
    }
}