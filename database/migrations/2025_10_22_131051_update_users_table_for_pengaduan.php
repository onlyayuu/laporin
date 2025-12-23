<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 200)->after('id')->unique();
            $table->string('nama_pengguna', 200)->after('username');
            $table->enum('role', ['admin', 'petugas', 'guru', 'siswa'])->default('siswa')->after('password');

            // Hapus kolom name yang tidak diperlukan
            $table->dropColumn('name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn(['username', 'nama_pengguna', 'role']);
        });
    }
};
