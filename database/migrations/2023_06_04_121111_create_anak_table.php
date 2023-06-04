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
            $table->unsignedBigInteger('keluarga_id');
            $table->string('name');
            $table->string('nik')->nullable();
            $table->string('no_akta')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->decimal('bb', 5, 2);
            $table->integer('tb');
            $table->integer('lk');
            $table->string('golongan_darah', 5)->nullable();
            $table->string('no_medic')->nullable();
            $table->string('nrkb')->nullable();
            $table->string('nrkbap')->nullable();
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
        Schema::dropIfExists('anak');
    }
};