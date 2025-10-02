<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 2 admins
        User::factory()->create([
            'name' => 'Admin One',
            'email' => 'admin1@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Admin Two',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 10 customers
        User::factory(10)->create();

        // 5 categories, 20 products total
        Category::factory(5)->create()->each(function($c){
            Product::factory(4)->create(['category_id'=>$c->id]);
        });

        // 10 carts
        Cart::factory(10)->create();

        // 15 orders with payments
        Order::factory(15)->create()->each(function($order){
            Payment::factory()->create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
            ]);
        });
    }
}
