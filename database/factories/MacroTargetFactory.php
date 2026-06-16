<?php

namespace Database\Factories;

use App\Models\MacroTarget;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MacroTarget>
 */
class MacroTargetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'        => User::factory(),
            'weight_kg'      => $this->faker->randomFloat(2, 50, 120),
            'height_cm'      => $this->faker->randomFloat(2, 150, 200),
            'age'            => $this->faker->numberBetween(18, 60),
            'sex'            => $this->faker->randomElement(['male', 'female']),
            'activity_level' => $this->faker->randomElement(['sedentary', 'light', 'moderate', 'active', 'very_active']),
            'goal'           => $this->faker->randomElement(['lose', 'maintain', 'gain']),
            'preset'         => null,
            'daily_calories' => $this->faker->numberBetween(1500, 3500),
            'protein_g'      => $this->faker->numberBetween(100, 250),
            'carbs_g'        => $this->faker->numberBetween(150, 400),
            'fat_g'          => $this->faker->numberBetween(50, 120),
        ];
    }
}
