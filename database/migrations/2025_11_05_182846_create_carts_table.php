<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('qty');
            $table->decimal('unit_price', 12, 2); // اسنپ‌شات قیمت هنگام افزودن
            $table->json('snapshot')->nullable(); // عنوان/کاور/ویژگی‌ها
            $table->timestamps();
            // $table->primary(['user_id','product_id']); // هر کاربر یک سبد فعال
        });
    }

    public function down(): void {
        Schema::dropIfExists('carts');
    }
};
