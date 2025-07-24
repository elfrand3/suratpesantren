<?php

namespace App\Exports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithIndex;

class SantriExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Santri::select('nis', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'kelas', 'status', 'alamat', 'no_telp', 'nama_ortu', 'alamat_ortu')->get();
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Kelas',
            'Status',
            'Alamat',
            'No Telp',
            'Nama Ortu',
            'Alamat Ortu'
        ];
    }
}
