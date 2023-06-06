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
        Schema::create('penimbangan', function (Blueprint $table) {
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
            $table->unsignedBigInteger('anak_id');
            $table->foreign('anak_id')
                ->references('id')
                ->on('anak')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('id_layanan')->unique();
            $table->integer('usia');
            $table->decimal('bb', 5, 2);
            $table->integer('tb');
            $table->string('bb_status')->nullable();
            $table->string('tb_status')->nullable();
            $table->string('suplemen')->nullable();
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
        Schema::dropIfExists('penimbangan');
    }
};
