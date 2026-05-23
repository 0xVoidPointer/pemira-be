<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\ElectionCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => ElectionCategory::factory(),
            'number' => fake()->numberBetween(1, 10),
            'vision' => fake()->paragraph(3),
            'mission' => implode("\n", [
                '1. '.fake()->sentence(),
                '2. '.fake()->sentence(),
                '3. '.fake()->sentence(),
                '4. '.fake()->sentence(),
            ]),
            'photo_url' => fake()->imageUrl(640, 480, 'people'),
            'video_url' => 'https://www.youtube.com/watch?v='.fake()->regexify('[A-Za-z0-9_-]{11}'),
        ];
    }
}
