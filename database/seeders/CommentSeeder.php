<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fa_IR');

        for ($i = 1; $i <= 20; $i++) {

            Comment::create([
                'product_id' => rand(1, 20),     // رندوم از 1 تا 20
                'user_id'    => rand(1, 10),     // فقط 1 تا 10
                'parent_id'  => (rand(1, 100) > 85) ? rand(1, $i - 1) : null, // 15% احتمال پاسخ بودن
                'title'      => $faker->sentence(2),
                'content'    => $faker->paragraph(),
                'rating'     => rand(1, 5),
                'is_active'  => rand(0, 1), // فعال یا غیرفعال
            ]);
        }
    }
}
