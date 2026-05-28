<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    public function run(): void
    {
        $faculties = [
            ['code' => 'E', 'name' => 'Fakultas Teknik', 'dean_name' => 'test', 'is_active' => true],
            ['code' => 'B', 'name' => 'Fakultas Ekonomi dan Bisnis', 'dean_name' => 'Dr. Citra', 'is_active' => true],
            ['code' => 'D', 'name' => 'Fakultas Kesehatan', 'dean_name' => 'Dr. Dian', 'is_active' => true],
            ['code' => 'K', 'name' => 'Fakultas Kedokteran', 'dean_name' => 'Dr. Eka', 'is_active' => true],
            ['code' => 'A', 'name' => 'Fakultas Ilmu Komputer', 'dean_name' => 'Dr. Fajar', 'is_active' => true],
        ];

        foreach ($faculties as $data) {
            Faculty::factory()->create($data);
        }
    }
}
