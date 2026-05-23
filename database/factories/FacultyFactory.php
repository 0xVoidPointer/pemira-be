<?php

namespace Database\Factories;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faculty>
 */
class FacultyFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->lexify('F???')),
            'name' => 'Fakultas '.fake()->randomElement([
                'Teknik',
                'Ilmu Komputer',
                'Ekonomi dan Bisnis',
                'Hukum',
                'Kedokteran',
                'Matematika dan Ilmu Pengetahuan Alam',
                'Ilmu Sosial dan Politik',
                'Pertanian',
                'Psikologi',
                'Sastra',
            ]),
            'dean_name' => 'Prof. Dr. '.fake('id_ID')->name(),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
