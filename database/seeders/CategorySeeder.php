<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'طلا و جواهرات',
                'description' => 'محصولات مرتبط با طلا، انگشتر، گردنبند و دستبند.',
                'status' => 'active',
            ],
            [
                'name' => 'عطر و ادکلن',
                'description' => 'انواع عطر زنانه و مردانه.',
                'status' => 'active',
            ],
            [
                'name' => 'لوازم دیجیتال',
                'description' => 'گوشی، لپتاپ، ساعت هوشمند و ...',
                'status' => 'active',
            ],
            [
                'name' => 'پوشاک',
                'description' => 'لباس زنانه، مردانه و بچگانه.',
                'status' => 'active',
            ],
            [
                'name' => 'خانه و آشپزخانه',
                'description' => 'لوازم آشپزخانه، دکور و ابزار منزل.',
                'status' => 'inactive', // یکی غیرفعال برای تست
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
