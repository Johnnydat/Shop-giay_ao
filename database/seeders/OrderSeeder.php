<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Lấy danh sách người dùng để gán mối quan hệ
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('Please seed Users table first.');
            return;
        }

        // Tạo 10 đơn hàng giả
        for ($i = 0; $i < 10; $i++) {
            $order = Order::create([
                'user_id' => $faker->randomElement($users)->id,
                'order_code' => 'ORD-' . strtoupper($faker->lexify('???????')),
                'total_amount' => $faker->randomFloat(2, 50, 1000), // Tổng tiền từ 50 đến 1000
                'status' => $faker->randomElement(array_keys(Order::STATUSES)),
                'payment_method' => $faker->randomElement(['cash_on_delivery', 'credit_card', 'bank_transfer']),
                'shipping_address' => $faker->address,
                'billing_address' => $faker->address,
                'customer_name' => $faker->name,
                'customer_email' => $faker->email,
                'customer_phone' => $faker->phoneNumber,
                'notes' => $faker->optional()->sentence,
            ]);

            // Tạo các mục (items) ngẫu nhiên cho đơn hàng
            $itemCount = $faker->numberBetween(1, 5); // Số lượng mục từ 1 đến 5
            for ($j = 0; $j < $itemCount; $j++) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $faker->numberBetween(1, 20), // Giả sử có 50 sản phẩm
                    'quantity' => $faker->numberBetween(1, 10),
                    'price' => $faker->randomFloat(2, 10, 500),
                ]);
            }
        }

        $this->command->info('10 order records have been seeded successfully.');
    }
}