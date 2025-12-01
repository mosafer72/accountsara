<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use Faker\Factory as Faker;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fa_IR');

        // مرحله 1: ایجاد 10 تیکت اصلی (بدون parent_id)
        for ($i = 1; $i <= 10; $i++) {

            Ticket::create([
                'user_id'  => rand(1, 10),
                'parent_id' => null,
                'subject'   => $faker->sentence(3),
                'content'   => $faker->paragraph(),
                'status'    => $faker->randomElement(['open', 'closed']),
            ]);
        }

        // مرحله 2: ایجاد 10 پاسخ (reply) برای تیکت‌های بالا
        for ($i = 1; $i <= 10; $i++) {

            // انتخاب یک تیکت اصلی برای پاسخ
            $parentTicket = Ticket::whereNull('parent_id')->inRandomOrder()->first();

            Ticket::create([
                'user_id'  => rand(1, 10),
                'parent_id' => $parentTicket->id,
                'subject'   => 'پاسخ: ' . $parentTicket->subject,
                'content'   => $faker->paragraph(),
                'status'    => $parentTicket->status, // همان وضعیت پدر
            ]);
        }
    }
}
