<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'gender',
        'telp'
    ];

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_petugas');
    }
}
