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
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');

      $table->string('number')->unique();             // مثل ORD-ABCD1234

      // مبالغ
      $table->decimal('subtotal', 12, 2)->default(0); // جمع جزء (= جمع آیتم‌ها)
      $table->decimal('coupon_discount', 12, 2)->default(0);
      $table->decimal('total', 12, 2)->default(0);    // مبلغ قابل پرداخت = subtotal - coupon_discount

      // کوپن
      $table->string('coupon_code')->nullable();

      $table->string('currency', 10)->default('USD');

      // وضعیت سفارش
      $table->enum('status', ['pending','paid','delivering','completed','canceled','disputed'])
        ->default('pending');

      $table->timestamp('paid_at')->nullable();

      // متادیتا (هر چیز اضافی: آی‌پی، نوت، …)
      $table->json('meta')->nullable();

      $table->timestamps();
      $table->index(['user_id','status']);
    });
  }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
