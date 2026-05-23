<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    public function run(): void
    {
        $faculties = [
            ['code' => 'FT', 'name' => 'Fakultas Teknik'],
            ['code' => 'FILKOM', 'name' => 'Fakultas Ilmu Komputer'],
            ['code' => 'FEB', 'name' => 'Fakultas Ekonomi dan Bisnis'],
            ['code' => 'FH', 'name' => 'Fakultas Hukum'],
            ['code' => 'FK', 'name' => 'Fakultas Kedokteran'],
            ['code' => 'FMIPA', 'name' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam'],
            ['code' => 'FISIP', 'name' => 'Fakultas Ilmu Sosial dan Politik'],
            ['code' => 'FP', 'name' => 'Fakultas Pertanian'],
            ['code' => 'FPSI', 'name' => 'Fakultas Psikologi'],
            ['code' => 'FIB', 'name' => 'Fakultas Ilmu Budaya'],
        ];

        foreach ($faculties as $data) {
            Faculty::factory()->create($data);
        }
    }
}
