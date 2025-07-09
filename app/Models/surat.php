<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class surat extends Model
{
    protected $fillable = [
        'nomor_surat',
        'jenis_surat',
        'tanggal_surat',
        'perihal',
        'status',
        'template_surat',
        'nis',
        'nama_santri',
        'alasan',
        'diagnosa',
        'tanggal_kembali',
        'content',
        'santri_id',
        'file_surat'
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_kembali' => 'date',
    ];

    // Relationship with Santri
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
