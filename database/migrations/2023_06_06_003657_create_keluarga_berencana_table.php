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
        Schema::create('keluarga_berencana', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('posko_id');
            $table->foreign('posko_id')
                ->references('id')
                ->on('posko')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->unsignedBigInteger('petugas_id');
            $table->foreign('petugas_id')
                ->references('id')
                ->on('petugas_kesehatan')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->unsignedBigInteger('ibu_id');
            $table->foreign('ibu_id')
                ->references('id')
                ->on('ibu')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('id_layanan')->unique();
            $table->string('metode');
            $table->text('keluhan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga_berencana');
    }
};
