<?php

namespace Database\Factories;

use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected static ?string $password;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $enrollmentYear = fake()->numberBetween(2020, (int) date('Y'));
        $shortYear = substr((string) $enrollmentYear, -2);

        return [
            'faculty_id' => Faculty::factory(),
            'nim' => $shortYear.fake()->unique()->numerify('########'),
            'full_name' => fake('id_ID')->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'is_eligible' => true,
            'enrollment_year' => $enrollmentYear,
            'remember_token' => Str::random(10),
        ];
    }

    public function ineligible(): static
    {
        return $this->state(fn () => ['is_eligible' => false]);
    }

    public function forFaculty(Faculty $faculty): static
    {
        return $this->state(fn () => ['faculty_id' => $faculty->id]);
    }
}
