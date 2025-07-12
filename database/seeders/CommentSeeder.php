<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách người dùng và sản phẩm để gán mối quan hệ
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('Please seed Users and Products tables first.');
            return;
        }

        // Tạo 50 bình luận giả
        for ($i = 0; $i < 50; $i++) {
            Comment::create([
                'content' => $faker->paragraph,
                'status' => $faker->randomElement(['approved', 'pending', 'rejected']),
                'user_id' => $faker->randomElement($users)->id,
                'product_id' => $faker->randomElement($products)->id,
                'parent_id' => $faker->optional()->randomElement(Comment::all()->pluck('id')->toArray()),
            ]);
        }

        $this->command->info('50 comment records have been seeded successfully.');
    }
}
