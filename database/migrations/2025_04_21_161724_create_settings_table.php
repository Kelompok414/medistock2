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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel user_settings
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Kolom-kolom pengaturan tampilan
            $table->string('language', 10)->default('id'); // Menggunakan kode ISO (id, en, ko, zh)
            $table->string('text_size', 20)->default('default'); // 'default', 'small', 'medium', 'large', 'extra_large'
            $table->string('font_family', 50)->default('Default'); // Nama font yang dipilih (e.g., "Open Sans", "Arial")
            $table->string('theme', 50)->default('Default'); // 'Default', 'Dark', dll. (bisa dikembangkan)
            $table->integer('brightness')->default(100); // Nilai kecerahan 50-150
            $table->boolean('dark_mode')->default(false); // true/false

            $table->timestamps();

            $table->unique('user_id'); // Memastikan setiap user hanya memiliki satu entri tampilan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
