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
        Schema::create('keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk')->unique();
            $table->string('kepala_keluarga');
            $table->string('telp_keluarga');
            $table->string('kelurahan');
            $table->string('jalan');
            $table->string('rt', 2);
            $table->string('rw', 2);
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->string('kode_pos');
            $table->string('jenis_asuransi')->nullable();
            $table->string('nomor_pelayanan')->nullable();
            $table->string('tanggal_berlaku')->nullable();
            $table->string('puskesmas_domisili');
            $table->text('alamat_puskesmas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga');
    }
};