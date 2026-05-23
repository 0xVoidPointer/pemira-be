<?php

namespace Database\Factories;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AuditLog>
 */
class AuditLogFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventType = fake()->randomElement([
            'user.login',
            'user.logout',
            'period.created',
            'period.updated',
            'category.created',
            'candidate.registered',
            'ballot.cast',
        ]);

        return [
            'actor_id' => User::factory(),
            'event_type' => $eventType,
            'entity_type' => fake()->randomElement(['User', 'ElectionPeriod', 'Candidate', 'Ballot']),
            'entity_id' => fake()->uuid(),
            'meta' => [
                'note' => fake()->sentence(),
            ],
            'ip_address' => fake()->ipv4(),
        ];
    }
}
