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
        Schema::create('permintaan_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->string('no_permintaan');
            $table->foreignId('id_pasien')->constrained('pasiens')->cascadeOnDelete();
            $table->foreignId('id_dokter')->constrained('dokters')->cascadeOnDelete();
            $table->foreignId('id_jenis')->constrained('jenis_pemeriksaans')->cascadeOnDelete();
            $table->enum('status_pemeriksaan', ['antri', 'proses', 'selesai', 'arsip'])->default('antri');
            $table->date('tanggal_permintaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_pemeriksaans');
    }
};
