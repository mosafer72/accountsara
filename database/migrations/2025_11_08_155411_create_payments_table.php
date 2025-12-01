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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('provider');            // idpay|mock|...
            $table->string('provider_id')->nullable();   // شناسه تراکنش در درگاه (idpay: id)
            $table->string('provider_track_id')->nullable(); // track_id
            $table->string('provider_order_id')->nullable(); // order_id در درگاه
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['init','redirected','succeeded','failed','canceled'])->default('init');
            $table->json('request_payload')->nullable();
            $table->json('callback_payload')->nullable();
            $table->timestamps();
            $table->index(['order_id','provider','status']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
