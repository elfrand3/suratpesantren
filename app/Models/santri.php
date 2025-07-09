<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class santri extends Model
{
    use HasFactory;
    protected $table = 'santris';
    protected $fillable = [
        'nama',
        'nis',
        'kelas',
        'alamat',
        'status',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_telp',
        'nama_ortu',
        'alamat_ortu',
    ];

    public function surats()
    {
        return $this->hasMany(surat::class);
    }
}
