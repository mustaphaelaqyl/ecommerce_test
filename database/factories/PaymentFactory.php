<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Payment;
use App\Models\Order;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        $statuses = ['success', 'failed', 'refunded'];

        return [
            'order_id' => Order::inRandomOrder()->first()->id ?? Order::factory(),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'status' => fake()->randomElement($statuses),
        ];
    }
}