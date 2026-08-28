<?php

namespace Database\Seeders;

use App\Models\PlacementTypeMaster;
use Illuminate\Database\Seeder;

class PlacementTypeMasterSeeder extends Seeder
{
    public function run(): void
    {
        $placements = [
            'CKM',
            'Kader',
            'Woksyop',
            'Pasukan Projek',
            'Sektor Bangunan',
            'Negeri',
            'Sektor Infrastruktur',
            'Sektor Pengurusan / Portfolio Pengurusan',
            'Cawangan / Bahagian di bawah Sektor Ibu Pejabat',
        ];

        foreach ($placements as $placement) {
            PlacementTypeMaster::updateOrCreate(
                ['name' => $placement],
                ['is_active' => true]
            );
        }
    }
}