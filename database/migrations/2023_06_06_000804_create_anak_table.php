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
        Schema::create('anak', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('posko_id');
            $table->foreign('posko_id')
                ->references('id')
                ->on('posko')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->unsignedBigInteger('ibu_id');
            $table->foreign('ibu_id')
                ->references('id')
                ->on('ibu')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('nama');
            $table->string('nik')->nullable()->unique();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['lk', 'pr']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak');
    }
};
