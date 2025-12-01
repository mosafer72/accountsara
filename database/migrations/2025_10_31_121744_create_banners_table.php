<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');               // عنوان بنر
            $table->string('image');               // مسیر تصویر
            $table->string('link')->nullable();    // لینک (اختیاری)
            $table->enum('position', ['top','middle','bottom'])->default('top'); // موقعیت نمایش
            $table->boolean('is_active')->default(true); // فعال / غیرفعال
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete(); // کاربر ایجاد کننده
            $table->timestamp('start_at')->nullable();   // زمان شروع نمایش
            $table->timestamp('end_at')->nullable();     // زمان پایان نمایش
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
