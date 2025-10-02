<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        $statuses = ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'];

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'total_amount' => fake()->randomFloat(2, 20, 1000),
            'status' => fake()->randomElement($statuses),
        ];
    }
}