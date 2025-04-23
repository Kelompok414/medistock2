<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->date('dob')->nullable(); // Tanggal lahir
            $table->string('gender')->nullable(); // Gender: "Laki Laki", "Perempuan"
            $table->boolean('two_step_verification')->default(false); // Verifikasi 2 langkah
            $table->string('device')->nullable(); // Nama perangkat
            $table->string('recovery_email')->nullable(); // Email pemulihan
            $table->string('recovery_phone')->nullable(); // Telepon pemulihan
            $table->boolean('security_notification')->default(true); // Notifikasi keamanan
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
