<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'nama_pengguna',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan pengaduan
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_user');
    }

    // Cek role user
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    public function isGuru()
    {
        return $this->role === 'guru';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }

    public function isPengguna()
    {
        return in_array($this->role, ['guru', 'siswa']);
    }

    // Relationship dengan petugas jika role petugas
    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'id_petugas', 'id_user');
    }

    // Di dalam Model User
public function getRoleColorAttribute()
{
    $colors = [
        'admin' => '9b59b6',
        'petugas' => '2ecc71',
        'guru' => 'f39c12',
        'siswa' => '3498db'
    ];
    return $colors[$this->role] ?? '3498db';
}
}
