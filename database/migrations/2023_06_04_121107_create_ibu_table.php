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
        Schema::create('ibu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('keluarga_id');
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('telp');
            $table->string('golongan_darah', 5)->nullable();
            $table->string('no_medic')->nullable();
            $table->string('nrki')->nullable();
            $table->timestamps();

            $table->foreign('keluarga_id')
                ->references('id')
                ->on('keluarga')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibu');
    }
};