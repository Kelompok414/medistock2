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
        Schema::create('fonts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama font yang akan ditampilkan (e.g., "Open Sans")
            $table->string('css_family')->nullable(); // Nama font untuk CSS (e.g., "'Open Sans', sans-serif")
            $table->string('google_font_name')->nullable(); // Nama font di Google Fonts API (e.g., "Open+Sans")
            $table->timestamps();
        });

        // Seed data font awal
        DB::table('fonts')->insert([
            ['name' => 'Default', 'css_family' => 'Arial, sans-serif', 'google_font_name' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Calibri', 'css_family' => 'Calibri, sans-serif', 'google_font_name' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fonts');
    }
};
