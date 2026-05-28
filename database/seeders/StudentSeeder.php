<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $faculties = Faculty::all();
        $password = Hash::make('student123');

        // Pinned test student (mengikuti pola NIM: {CODE}{YY}{seq})
        $first = $faculties->first();
        $demoYear = 2024;
        $demoNim = sprintf('%s%02d%06d', strtoupper($first->code), $demoYear % 100, 1);

        Student::factory()->forFaculty($first)->create([
            'nim' => $demoNim,
            'full_name' => 'Mahasiswa Demo',
            'email' => strtolower($demoNim).'@student.pemira.test',
            'password' => $password,
            'enrollment_year' => $demoYear,
        ]);

        // 30 students per faculty
        $faculties->each(function (Faculty $faculty) use ($password): void {
            $existing = Student::where('faculty_id', $faculty->id)->count();

            for ($i = 0; $i < 30; $i++) {
                $seq = $existing + $i + 1;
                $year = fake()->numberBetween(2018, 2025);
                $nim = sprintf('%s%02d%06d', strtoupper($faculty->code), $year % 100, $seq);

                Student::factory()->forFaculty($faculty)->create([
                    'nim' => $nim,
                    'email' => strtolower($nim).'@student.pemira.test',
                    'password' => $password,
                    'enrollment_year' => $year,
                ]);
            }
        });

        // Some ineligible students (juga ikut pola NIM baru)
        $ineligibleFaculty = $faculties->random();
        $ineligibleExisting = Student::where('faculty_id', $ineligibleFaculty->id)->count();

        for ($i = 0; $i < 5; $i++) {
            $seq = $ineligibleExisting + $i + 1;
            $year = fake()->numberBetween(2018, 2025);
            $nim = sprintf('%s%02d%06d', strtoupper($ineligibleFaculty->code), $year % 100, $seq);

            Student::factory()
                ->forFaculty($ineligibleFaculty)
                ->ineligible()
                ->create([
                    'nim' => $nim,
                    'email' => strtolower($nim).'@student.pemira.test',
                    'password' => $password,
                    'enrollment_year' => $year,
                ]);
        }
    }
}
