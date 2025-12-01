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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('price');
            $table->integer('quantity')->default(0);
            $table->string('image')->nullable();
            $table->string('banner')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('type')->nullable(); 
            $table->boolean('needle')->nullable(); //نفرات مورد نیاز
            $table->boolean('show_on_site')->default(true); // نمایش در سایت
            $table->decimal('discount_percent', 5, 2)->default(0); // درصد تخفیف
            $table->decimal('sell_count', 5, 2)->default(0); // درصد تخفیف
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
