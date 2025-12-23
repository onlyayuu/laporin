<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $primaryKey = 'id_item';
    public $timestamps = true;

    protected $fillable = [
        'nama_item',
        'deskripsi',
        'foto'
    ];

    // Relasi many-to-many dengan Lokasi
    public function lokasis()
    {
        return $this->belongsToMany(Lokasi::class, 'list_lokasi', 'id_item', 'id_lokasi');
    }

    // Relasi ke list_lokasi
    public function listLokasi()
    {
        return $this->hasMany(ListLokasi::class, 'id_item');
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_item');
    }
}
