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
        Schema::create('hasil_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_permintaan')->constrained('permintaan_pemeriksaans')->cascadeOnDelete();
            $table->foreignId('id_parameter')->constrained('parameter_pemeriksaans')->cascadeOnDelete();
            $table->decimal('nilai_hasil', 8, 2);
            $table->enum('status', ['normal', 'rendah', 'tinggi'])->default('normal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_pemeriksaans');
    }
};
