<?php

namespace Tests\Feature;

use App\Models\Dish;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_CreatedDishes_returns_DishArray(): void
    {
        $user = User::factory()
            ->hasAttached(Dish::factory()->count(3))
            ->make(['name' => 'test user']);
        $user->save();

        $this->assertCount(3, $user->createdDishes());
        foreach ($user->createdDishes() as $dish) {
            $this->assertInstanceOf(Dish::class, $dish);
        }
    }
}
