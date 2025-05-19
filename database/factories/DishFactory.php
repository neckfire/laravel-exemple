<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Xefi\Faker\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
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
            'name' => $faker->name(),
            'recipe' => $faker->sentences(sentences: 3),
            'owner_id' => $faker->number(min: 1, max: 10),
            'image' => "images/image.gif",
        ];
    }
}
