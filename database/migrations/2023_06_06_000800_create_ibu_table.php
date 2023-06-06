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

            $table->unsignedBigInteger('posko_id');
            $table->foreign('posko_id')
                ->references('id')
                ->on('posko')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('telp');
            $table->date('tanggal_lahir');
            $table->string('jalan');
            $table->string('rt', 2);
            $table->string('rw', 2);
            $table->string('ayah');
            $table->string('darah', 5);
            $table->timestamps();
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
