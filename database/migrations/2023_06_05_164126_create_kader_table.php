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
        Schema::create('kader', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('posko_id');

            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('telp');
            $table->text('jalan');
            $table->string('rt', 2);
            $table->string('rw', 2);
            $table->timestamps();

            $table->foreign('posko_id')
                ->references('id')
                ->on('posko')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kader');
    }
};
