<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->superAdmin()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@pemira.test',
        ]);

        User::factory()->create([
            'name' => 'Admin Pemira',
            'email' => 'admin@pemira.test',
            'role' => UserRole::Admin,
        ]);

        User::factory()->count(3)->create();
    }
}
