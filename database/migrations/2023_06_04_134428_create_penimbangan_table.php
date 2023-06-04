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
            $table->unsignedBigInteger('anak_id');
            $table->unsignedBigInteger('petugas_kesehatan_id');
            $table->unsignedBigInteger('pos_pemeriksaan_id');
            $table->tinyInteger('usia')->unsigned();
            $table->decimal('bb', 5, 2);
            $table->integer('tb');
            $table->integer('lk');
            $table->string('suplemen')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('anak_id')
                ->references('id')
                ->on('anak')
                ->onDelete('cascade');
            $table->foreign('petugas_kesehatan_id')
                ->references('id')
                ->on('petugas_kesehatan')
                ->onDelete('cascade');
            $table->foreign('pos_pemeriksaan_id')
                ->references('id')
                ->on('pos_pemeriksaan')
                ->onDelete('cascade');
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