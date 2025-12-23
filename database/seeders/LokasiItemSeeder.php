<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiItemSeeder extends Seeder
{
    public function run()
    {
        // Data lokasi
        $lokasis = [
            ['nama_lokasi' => 'Lab Komputer 1'],
            ['nama_lokasi' => 'Lab Komputer 2'],
            ['nama_lokasi' => 'Kelas X RPL'],
            ['nama_lokasi' => 'Ruang Guru'],
        ];

        foreach ($lokasis as $lokasi) {
            Lokasi::create($lokasi);
        }

        // Data items
        $items = [
            ['nama_item' => 'Komputer PC', 'deskripsi' => 'Komputer untuk praktikum'],
            ['nama_item' => 'Monitor', 'deskripsi' => 'Monitor LCD 21 inch'],
            ['nama_item' => 'Kursi Siswa', 'deskripsi' => 'Kursi kayu untuk siswa'],
            ['nama_item' => 'Meja Komputer', 'deskripsi' => 'Meja khusus komputer'],
            ['nama_item' => 'AC Split', 'deskripsi' => 'AC 1 PK'],
            ['nama_item' => 'Proyektor', 'deskripsi' => 'Proyektor LCD'],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }

        // Relasikan items dengan lokasi (many-to-many)
        DB::table('list_lokasi')->insert([
            // Lab Komputer 1
            ['id_lokasi' => 1, 'id_item' => 1], // Komputer
            ['id_lokasi' => 1, 'id_item' => 2], // Monitor
            ['id_lokasi' => 1, 'id_item' => 3], // Kursi
            ['id_lokasi' => 1, 'id_item' => 4], // Meja

            // Lab Komputer 2
            ['id_lokasi' => 2, 'id_item' => 1], // Komputer
            ['id_lokasi' => 2, 'id_item' => 2], // Monitor
            ['id_lokasi' => 2, 'id_item' => 3], // Kursi
            ['id_lokasi' => 2, 'id_item' => 4], // Meja
            ['id_lokasi' => 2, 'id_item' => 5], // AC

            // Kelas X RPL
            ['id_lokasi' => 3, 'id_item' => 3], // Kursi
            ['id_lokasi' => 3, 'id_item' => 4], // Meja
            ['id_lokasi' => 3, 'id_item' => 6], // Proyektor

            // Ruang Guru
            ['id_lokasi' => 4, 'id_item' => 3], // Kursi
            ['id_lokasi' => 4, 'id_item' => 5], // AC
            ['id_lokasi' => 4, 'id_item' => 6], // Proyektor
        ]);

        echo "Data many-to-many berhasil dibuat!\n";
    }
}
