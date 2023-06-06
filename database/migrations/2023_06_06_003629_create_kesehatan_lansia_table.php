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
        Schema::create('kesehatan_lansia', function (Blueprint $table) {
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
            $table->unsignedBigInteger('lansia_id');
            $table->foreign('lansia_id')
                ->references('id')
                ->on('lansia')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('id_layanan')->unique();
            $table->decimal('bb', 5, 2)->nullable();
            $table->integer('tb')->nullable();
            $table->integer('tekanan_darah');
            $table->integer('kolestrol');
            $table->integer('gula_darah');
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
        Schema::dropIfExists('kesehatan_lansia');
    }
};
