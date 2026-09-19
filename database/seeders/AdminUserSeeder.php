<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $name = env('INITIAL_ADMIN_NAME');
        $email = env('INITIAL_ADMIN_EMAIL');
        $password = env('INITIAL_ADMIN_PASSWORD');

        if (! $name || ! $email || ! $password) {
            throw new RuntimeException(
                'Set INITIAL_ADMIN_NAME, INITIAL_ADMIN_EMAIL dan INITIAL_ADMIN_PASSWORD dalam .env dahulu.'
            );
        }

        if (strlen($password) < 12) {
            throw new RuntimeException(
                'INITIAL_ADMIN_PASSWORD mesti sekurang-kurangnya 12 aksara.'
            );
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'can_manage_structured_skills' => true,
            ]
        );
    }
}
