<?php

namespace Database\Factories;

use App\Enums\CandidateMemberRole;
use App\Models\Candidate;
use App\Models\CandidateMember;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CandidateMember>
 */
class CandidateMemberFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'candidate_id' => Candidate::factory(),
            'student_id' => Student::factory(),
            'role' => CandidateMemberRole::Individual,
        ];
    }

    public function ketua(): static
    {
        return $this->state(fn () => ['role' => CandidateMemberRole::Ketua]);
    }

    public function wakil(): static
    {
        return $this->state(fn () => ['role' => CandidateMemberRole::Wakil]);
    }
}
