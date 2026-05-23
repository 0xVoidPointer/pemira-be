<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\VoteTally;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VoteTally>
 */
class VoteTallyFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'candidate_id' => Candidate::factory(),
            'vote_count' => 0,
            'last_updated' => now(),
        ];
    }
}
