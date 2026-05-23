<?php

namespace Database\Factories;

use App\Models\Ballot;
use App\Models\ElectionCategory;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ballot>
 */
class BallotFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => ElectionCategory::factory(),
            'student_id' => Student::factory(),
            'voted_at' => now(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }
}
