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
            $table->string('jenis_kelamin')->nullable();
            $table->string('bulan')->nullable();
            $table->string('bb_min')->nullable();
            $table->string('bb_max')->nullable();
            $table->string('tb_min')->nullable();
            $table->string('tb_max')->nullable();
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
