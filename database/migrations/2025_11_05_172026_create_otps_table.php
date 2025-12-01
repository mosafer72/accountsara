<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_otps_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 20)->index();
            $table->string('code_hash');           // کد را هَش می‌کنیم، نه خام
            $table->string('purpose')->default('login'); // login|register|unified
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('otps');
    }
};
