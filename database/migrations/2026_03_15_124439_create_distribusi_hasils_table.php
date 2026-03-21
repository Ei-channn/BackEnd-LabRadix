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
        Schema::create('distribusi_hasils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_hasil')->constrained('hasil_pemeriksaans')->cascadeOnDelete();
            $table->date('tanggal_kirim');
            $table->boolean('dikirim_ke_dokter')->default(false);
            $table->boolean('dikirim_ke_pasien')->default(false);
            $table->enum('metode_pengiriman', ['WA', 'email', 'tele']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi_hasils');
    }
};
