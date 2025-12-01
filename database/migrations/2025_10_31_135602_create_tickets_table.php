<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // کاربر ایجادکننده
            $table->foreignId('parent_id')->nullable()->constrained('tickets')->onDelete('cascade'); // پدر (برای پاسخ‌ها)
            $table->string('subject'); // موضوع تیکت
            $table->text('content');  // متن تیکت یا پاسخ
            $table->enum('status',['open','closed'])->default('open'); // وضعیت تیکت (فقط برای تیکت اصلی)
            $table->enum('creator', ['admin','user'])->default('user');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
