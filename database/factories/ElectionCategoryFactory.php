<?php

namespace Database\Factories;

use App\Enums\ElectionCategoryType;
use App\Models\ElectionCategory;
use App\Models\ElectionPeriod;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ElectionCategory>
 */
class ElectionCategoryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(ElectionCategoryType::cases());

        $titles = [
            ElectionCategoryType::President->value => 'Presiden Mahasiswa',
            ElectionCategoryType::Dpm->value => 'Dewan Perwakilan Mahasiswa',
            ElectionCategoryType::FacultyGovernor->value => 'Gubernur Fakultas',
        ];

        return [
            'period_id' => ElectionPeriod::factory(),
            'scope_faculty_id' => $type === ElectionCategoryType::FacultyGovernor
                ? Faculty::factory()
                : null,
            'type' => $type,
            'title' => $titles[$type->value],
            'description' => fake()->paragraph(),
            'vote_start_at' => null,
            'vote_end_at' => null,
            'max_winners' => 1,
        ];
    }

    public function president(): static
    {
        return $this->state(fn () => [
            'type' => ElectionCategoryType::President,
            'title' => 'Presiden Mahasiswa',
            'scope_faculty_id' => null,
        ]);
    }

    public function dpm(): static
    {
        return $this->state(fn () => [
            'type' => ElectionCategoryType::Dpm,
            'title' => 'Dewan Perwakilan Mahasiswa',
            'scope_faculty_id' => null,
            'max_winners' => 5,
        ]);
    }

    public function facultyGovernor(?Faculty $faculty = null): static
    {
        return $this->state(fn () => [
            'type' => ElectionCategoryType::FacultyGovernor,
            'title' => 'Gubernur Fakultas',
            'scope_faculty_id' => $faculty?->id ?? Faculty::factory(),
        ]);
    }
}
