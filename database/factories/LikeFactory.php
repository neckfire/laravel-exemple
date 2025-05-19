<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Xefi\Faker\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = new Faker;

        return [
            'user_id' => $faker->number(min: 1, max: 10),
            'dish_id' => $faker->number(min: 1, max: 10),
        ];
    }
}
