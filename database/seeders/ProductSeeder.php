<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fa_IR');

        $categoryIds = Category::pluck('id')->toArray();
        $userIds     = User::pluck('id')->toArray();

        // تصاویر اسلایدر از HTML
        $productTitles = [
            // شبکه‌های اجتماعی
            'اکانت مجازی تلگرام',
            'اکانت مجازی واتساپ',
            'اکانت مجازی اینستاگرام',
            'اکانت مجازی توییتر (X)',
            'اکانت مجازی فیسبوک',
            'اکانت مجازی تیک‌تاک',
            'اکانت مجازی جیمیل (Google Account)',

            // سرویس‌ها و اشتراک‌ها
            'اکانت مجازی نتفلیکس',
            'اکانت مجازی اسپاتیفای',
            'اکانت مجازی چت‌جی‌پی‌تی (OpenAI)',
            'اکانت مجازی اپل آی‌دی',
            'اکانت مجازی آمازون',
            'اکانت مجازی استیم',
            'اکانت مجازی پابجی موبایل',
            'اکانت مجازی فورتنایت',
            'اکانت مجازی پلی‌استیشن (PSN)',
            'اکانت مجازی ایکس‌باکس',

            // شماره‌های مجازی
            'شماره مجازی آمریکا',
            'شماره مجازی کانادا',
            'شماره مجازی انگلیس',
            'شماره مجازی آلمان',
            'شماره مجازی ترکیه',
            'شماره مجازی روسیه',
            'شماره مجازی هند',

            // مالی و کارت‌ها
            'اکانت مجازی پی‌پال',
            'اکانت مجازی پیونیر',
            'اکانت مجازی اسکریل',
            'اکانت مجازی پرفکت‌مانی',
            'کارت مجازی ویزا یکبار مصرف',
            'کارت مجازی مسترکارت یکبار مصرف',
        ];

        $images = [
            'assets/img/slide-3d-1.png',
            'assets/img/slide-3d-2.png',
            'assets/img/slide-3d-3.png',
            'assets/img/slide-3d-4.png',
            'assets/img/slide-3d-5.png',
            'assets/img/slide-3d-6.png',
            'assets/img/slide-3d-7.png',
        ];

        for ($i = 1; $i <= 20; $i++) {

            $image = $faker->randomElement($images);

            Product::create([
                'title' => $faker->randomElement($productTitles),
                'description' => $faker->paragraph(),
                'price' => rand(100000, 20000000),
                'quantity' => rand(0, 40),
                'image' => $image,
                'banner' => $image, // اگر بنر هم از همین‌ها باشه
                'is_active' => rand(0, 1),
                'category_id' => $faker->randomElement($categoryIds),
                'user_id' => $faker->randomElement($userIds),
                'type' => rand(0, 1),
                'needle' => rand(0, 1),
                'show_on_site' => rand(0, 1),
                'discount_percent' => $faker->randomFloat(2, 0, 35),
                'sell_count'=> $faker->randomDigit(),
            ]);
        }
    }
}
