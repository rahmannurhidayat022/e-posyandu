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
        Schema::create('antropometri', function (Blueprint $table) {
            $table->id();
            $table->string('tipe')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('bulan')->nullable();
            $table->string('minus_3_sd')->nullable();
            $table->string('minus_2_sd')->nullable();
            $table->string('minus_1_sd')->nullable();
            $table->string('median')->nullable();
            $table->string('plus_1_sd')->nullable();
            $table->string('plus_2_sd')->nullable();
            $table->string('plus_3_sd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antropometri');
    }
};
