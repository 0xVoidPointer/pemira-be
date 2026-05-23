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

        // Pinned test student
        Student::factory()->forFaculty($faculties->first())->create([
            'nim' => '2400000001',
            'full_name' => 'Mahasiswa Demo',
            'email' => 'mahasiswa@pemira.test',
            'password' => Hash::make('password'),
            'enrollment_year' => 2024,
        ]);

        // 30 students per faculty
        $faculties->each(function (Faculty $faculty): void {
            Student::factory()
                ->count(30)
                ->forFaculty($faculty)
                ->create();
        });

        // Some ineligible students
        Student::factory()
            ->count(5)
            ->forFaculty($faculties->random())
            ->ineligible()
            ->create();
    }
}
