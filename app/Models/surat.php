<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class surat extends Model
{
    protected $table = 'surats';
    protected $fillable = [
        'nomor_surat',
        'jenis_surat',
        'tanggal_surat',
        'status',
        'alasan',
        'diagnosa',
        'content',
        'tanggal_kembali',
        'santri_id',
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
