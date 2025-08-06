<?php

namespace Database\Factories;

use App\Models\PerformanceContract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PerformanceContract>
 */
class PerformanceContractFactory extends Factory
{
    protected $model = PerformanceContract::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph(),
            'start_year' => $this->faker->year(),
            'end_year' => $this->faker->year(),
            'current_step' => $this->faker->numberBetween(1, 5),
            'created_by' => User::factory(),
            'status' => $this->faker->randomElement(['draft', 'submitted', 'approved', 'rejected']),
            'reviewer_id' => $this->faker->optional()->randomElement([User::factory()]),
            'reviewed_at' => $this->faker->optional()->dateTime(),
        ];
    }
}
