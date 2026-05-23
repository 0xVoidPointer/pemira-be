<?php

namespace Database\Factories;

use App\Enums\ElectionPeriodStatus;
use App\Models\ElectionPeriod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ElectionPeriod>
 */
class ElectionPeriodFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = fake()->unique()->numberBetween(2020, 2099);
        $regStart = fake()->dateTimeBetween('-1 year', 'now');
        $regEnd = (clone $regStart)->modify('+14 days');
        $voteStart = (clone $regEnd)->modify('+1 day');
        $voteEnd = (clone $voteStart)->modify('+3 days');

        return [
            'name' => 'Pemira '.$year,
            'year' => $year,
            'theme_config' => [
                'primary_color' => fake()->hexColor(),
                'secondary_color' => fake()->hexColor(),
                'logo_url' => fake()->imageUrl(200, 200, 'logo'),
                'banner_text' => 'Pemilihan Raya Mahasiswa '.$year,
            ],
            'reg_start_at' => $regStart,
            'reg_end_at' => $regEnd,
            'vote_start_at' => $voteStart,
            'vote_end_at' => $voteEnd,
            'status' => ElectionPeriodStatus::Draft,
            'created_by' => User::factory(),
        ];
    }

    public function voting(): static
    {
        return $this->state(fn () => ['status' => ElectionPeriodStatus::Voting]);
    }

    public function done(): static
    {
        return $this->state(fn () => ['status' => ElectionPeriodStatus::Done]);
    }
}
