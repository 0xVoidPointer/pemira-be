<?php

namespace Database\Seeders;

use App\Enums\CandidateMemberRole;
use App\Enums\ElectionPeriodStatus;
use App\Models\Candidate;
use App\Models\CandidateMember;
use App\Models\ElectionCategory;
use App\Models\ElectionPeriod;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\User;
use App\Models\VoteTally;
use Illuminate\Database\Seeder;

class ElectionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'superadmin@pemira.test')->first();
        $faculties = Faculty::all();

        $period = ElectionPeriod::factory()->create([
            'name' => 'Pemira 2026',
            'year' => 2026,
            'status' => ElectionPeriodStatus::Voting,
            'reg_start_at' => now()->subDays(30),
            'reg_end_at' => now()->subDays(10),
            'vote_start_at' => now()->subDay(),
            'vote_end_at' => now()->addDays(2),
            'created_by' => $admin?->id,
        ]);

        $presidentCategory = ElectionCategory::factory()
            ->president()
            ->create([
                'period_id' => $period->id,
                'title' => 'Presiden Mahasiswa 2026',
            ]);

        $dpmCategory = ElectionCategory::factory()
            ->dpm()
            ->create([
                'period_id' => $period->id,
                'title' => 'Dewan Perwakilan Mahasiswa 2026',
            ]);

        $this->seedPairCandidates($presidentCategory, $faculties, count: 3);
        $this->seedIndividualCandidates($dpmCategory, $faculties, count: 5);

        foreach ($faculties as $faculty) {
            $facultyCategory = ElectionCategory::factory()
                ->facultyGovernor($faculty)
                ->create([
                    'period_id' => $period->id,
                    'title' => "Gubernur {$faculty->code} 2026",
                ]);

            $this->seedPairCandidates($facultyCategory, collect([$faculty]), count: 2);
        }
    }

    private function seedPairCandidates(ElectionCategory $category, $facultyPool, int $count): void
    {
        for ($i = 1; $i <= $count; $i++) {
            $candidate = Candidate::factory()->create([
                'category_id' => $category->id,
                'number' => $i,
            ]);

            $faculty = $facultyPool->random();
            $ketua = Student::factory()->forFaculty($faculty)->create();
            $wakil = Student::factory()->forFaculty($facultyPool->random())->create();

            CandidateMember::factory()->ketua()->create([
                'candidate_id' => $candidate->id,
                'student_id' => $ketua->id,
            ]);

            CandidateMember::factory()->wakil()->create([
                'candidate_id' => $candidate->id,
                'student_id' => $wakil->id,
            ]);

            VoteTally::factory()->create([
                'candidate_id' => $candidate->id,
                'vote_count' => fake()->numberBetween(0, 500),
            ]);
        }
    }

    private function seedIndividualCandidates(ElectionCategory $category, $facultyPool, int $count): void
    {
        for ($i = 1; $i <= $count; $i++) {
            $candidate = Candidate::factory()->create([
                'category_id' => $category->id,
                'number' => $i,
            ]);

            $student = Student::factory()->forFaculty($facultyPool->random())->create();

            CandidateMember::factory()->create([
                'candidate_id' => $candidate->id,
                'student_id' => $student->id,
                'role' => CandidateMemberRole::Individual,
            ]);

            VoteTally::factory()->create([
                'candidate_id' => $candidate->id,
                'vote_count' => fake()->numberBetween(0, 300),
            ]);
        }
    }
}
