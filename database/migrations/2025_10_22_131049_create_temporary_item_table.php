<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('temporary_item', function (Blueprint $table) {
            $table->id('id_temporary');
            $table->foreignId('id_item')->constrained('items', 'id_item');
            $table->string('nama_barang_baru', 50);
            $table->string('lokasi_barang_baru', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temporary_item');
    }
};
