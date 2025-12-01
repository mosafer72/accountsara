<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان تخفیف
            $table->enum('type', ['percentage','fixed'])->default('percentage'); // درصدی یا مبلغ ثابت
            $table->decimal('value', 10, 2); // مقدار تخفیف
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete(); // دسته بندی (اختیاری)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // کاربر ایجادکننده
            $table->dateTime('start_at')->nullable(); // شروع بازه
            $table->dateTime('end_at')->nullable();   // پایان بازه
            $table->boolean('status')->default(true); // فعال یا غیرفعال
            $table->unsignedBigInteger('uses')->default(0);
            $table->timestamps();
        });

        Schema::create('discount_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_product');
        Schema::dropIfExists('discounts');
    }
};
