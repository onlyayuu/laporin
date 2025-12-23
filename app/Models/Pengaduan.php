<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';
    protected $primaryKey = 'id_pengaduan';

    // PERBAIKAN 1: Timestamps sebenarnya ADA dari struktur table
    public $timestamps = false; // Ubah jadi true karena ada created_at & updated_at

    protected $fillable = [
        'nama_pengaduan',
        'deskripsi',
        'lokasi',
        'foto',
        'status',
        'id_user',
        'id_petugas',
        'id_item',
        'tgl_pengajuan',
        'tgl_selesai',
        'saran_petugas',
        // PERBAIKAN 2: Tambahkan foto_selesai (setelah jalankan SQL)
        'foto_selesai'
    ];

    // PERBAIKAN 3: Tambah accessor untuk foto selesai
    public function getFotoSelesaiUrlAttribute()
    {
        if ($this->foto_selesai) {
            return asset('storage/' . $this->foto_selesai);
        }
        return null;
    }

    // PERBAIKAN 4: Tambah accessor untuk foto awal
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }

    // Relasi ke user (SUDAH BAGUS)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke petugas (SUDAH BAGUS)
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    // Relasi ke item (SUDAH BAGUS)
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
}
