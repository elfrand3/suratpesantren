<?php

namespace App\Exports;

use App\Models\surat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithIndex;

class SuratExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function collection()
    {
        $query = surat::with('santri');

        if ($this->bulan) {
            $query->whereMonth('tanggal_surat', $this->bulan);
        }

        return $query->get();
    }

    // Menerima $index sebagai parameter ke-2
    public function map($surat): array
    {
        return [
            ++$this->currentIndex,
            $surat->santri ? $surat->santri->nama : '',
            $surat->nomor_surat,
            $surat->jenis_surat,
            $surat->tanggal_surat->format('Y-m-d'),
            $surat->status,
            $surat->alasan,
            $surat->diagnosa,
            $surat->tanggal_kembali ? $surat->tanggal_kembali->format('Y-m-d') : '-',
        ];
    }

    // Atur heading di atas Excel
    public function headings(): array
    {
        return [
            'No',
            'Nama Santri',
            'Nomor Surat',
            'Jenis Surat',
            'Tanggal Surat',
            'Status',
            'Alasan',
            'Diagnosa',
            'Tanggal Kembali',
        ];
    }

    // Untuk menghitung index secara manual
    private $currentIndex = 0;
}



