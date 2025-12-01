<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fa_IR'); // فارسی برای نام‌ها

        // ایجاد 20 کاربر
        for ($i = 1; $i <= 20; $i++) {

            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => '09' . rand(100000000, 999999999),
                'password' => Hash::make('password123'), // پسورد پیش‌فرض
                'username' => $faker->userName,
                'avatar_url' => '/images/users/avatar.png',
                'is_admin' => 0, // همه کاربر معمولی
            ]);
        }

        // یک ادمین هم بسازیم
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '09120000000',
            'password' => Hash::make('admin123'),
            'username' => 'admin',
            'avatar_url' => '/images/users/avatar.png',
            'is_admin' => 1,
        ]);
    }
}
