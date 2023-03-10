<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory(1000)->create();
        Order::factory(1000)->create();
        $rows = [];
        for($i = 0; $i < 1000; $i++) {
            $rows[] = [
                'product_id' => Product::inRandomOrder()->first()->id,
                'order_id' => Order::inRandomOrder()->first()->id,
                'quantity' => fake()->randomNumber(2)
            ];
        }
        \DB::table('order_has_product')->insert($rows);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.ru',
            'password' => Hash::make('password')
        ]);
    }
}
