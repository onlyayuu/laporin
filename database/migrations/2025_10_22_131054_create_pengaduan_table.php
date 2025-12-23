<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->string('nama_pengaduan', 200);
            $table->text('deskripsi');
            $table->string('lokasi', 200);
            $table->string('foto', 200)->nullable();
            $table->enum('status', ['Diajukan', 'Disetujui', 'Ditolak', 'Diproses', 'Selesai'])->default('Diajukan');
            $table->foreignId('id_user')->constrained('users', 'id');
            $table->foreignId('id_petugas')->nullable()->constrained('petugas', 'id_petugas');
            $table->foreignId('id_item')->constrained('items', 'id_item');
            $table->date('tgl_pengajuan');
            $table->date('tgl_selesai')->nullable();
            $table->text('saran_petugas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
