<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Izin {{ $jenis_surat ?? '' }}</title>
    {{-- <link rel="stylesheet" href="{{ asset ('pdf.css')}}"> --}}
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            margin: 40px;
        }

        .text-center {
            text-align: center;
        }

        .signature {
            margin-top: 5px;
        }

        .indent {
            text-indent: 40px;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .kop-header {
            width: 100%;
            margin-bottom: 20px;
        }

        .kop-logo {
            width: 100px;
        }

        .kop-teks {
            text-align: center;
            font-size: 18px;
            line-height: 1.5;
        }

        .kop-alamat {
            margin: 0 auto 20px auto;
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            border: 1px solid black;
            padding: 5px;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Header dengan logo dan nama pesantren -->
    <table class="kop-header">
        <tr>
            <!-- Logo kiri -->
            <td style="width: 80px;">
                <img src="{{ public_path('logo.png') }}" class="kop-logo" alt="Logo" style="margin-left: 40px;">
            </td>


            <!-- Teks kanan -->
            <td class="kop-teks">
                <strong class="text-uppercase">
                    Pondok Pesantren<br>
                    Mambaul Ulum<br>
                    Kaliacar – Gading – Probolinggo
                </strong>
            </td>
        </tr>
    </table>

    <!-- Alamat dengan border -->
    <p class="kop-alamat">
        Jl. KH. Asy’ari Kaliacar, Gading. Email: <a>doktren_mambaululum@yahoo.com</a>
        Tlp. 0831-1234-51485 Pos: 67285
    </p>

    <div class="text-center">
        <strong>{{$nomor_surat}}</strong><br>
        {{-- <strong>003/PP-MU/D4/09-2025</strong><br> --}}
        <h2><u>SURAT IZIN {{ strtoupper($jenis_surat ?? '') }}</u></h2>
    </div>
    <p class="text-center">Assalamualaikum Wr. Wb</p>
    <p>Dengan ini kami menyatakan bahwa Nama Santri di bawah ini:</p>
    <p>
        Nama : {{ $santri->nama ?? '..................................................' }}<br>
        Alamat : {{ $santri->alamat ?? '..................................................' }}<br>
        Kelas : {{ $santri->kelas ?? '..................................................' }}
    </p>
    <p class="indent">
        Telah dinyatakan diberikan <strong>IZIN {{ strtoupper($jenis_surat ?? '') }}</strong> <u>{{ $alasan }}</u>
        terhitung sejak tanggal:
        {{ $tanggal_surat ?? '...' }} – {{ $tanggal_kembali ?? '...' }} M.<br>
        Batas waktu <strong>KEMBALI</strong> ke Pesantren pada tanggal:
        {{ $tanggal_kembali ?? '...' }} M.
    </p>
    <p class="indent">
        Demikian surat ini kami buat dengan sebenar-benarnya agar diperhatikan dan dipatuhi dengan sebaik mungkin.
    </p>

    {{-- <div class="text-center">
        <div class="signature">
            <p><i>Wassalamualaikum Wr. Wb</i></p>
            <p>Kaliacar, {{ $tanggal_surat ?? '___, ____________, 2025' }}</p>
            <p>Pengasuh Pesantren</p>
            <img src="{{ public_path('logosignatur.png') }}" class="kop-logo" alt="Logo" style="width: 130px;">
            <p><strong>KH. As'ad Abu Hasan</strong></p>
        </div>
    </div> --}}

    <div style="position: relative; margin-top: 20px; min-height: 180px;">
        @if($qr_image_base64)
            <div style="position: absolute; margin-top:120px ;top: 0; left: 0;">
                <img src="{{ $qr_image_base64 }}" alt="QR Code" style="width: 120px;">
            </div>
        @endif
        <div style="text-align: center;">
            <p><i>Wassalamualaikum Wr. Wb</i></p>
            <p>Kaliacar, {{ $tanggal_surat ?? '___, ____________, 2025' }}</p>
            <p>Pengasuh Pesantren</p>
            <img src="{{ public_path('logosignatur.png') }}" alt="Stempel" style="width: 130px;">
            <p><strong>KH. As'ad Abu Hasan</strong></p>
        </div>
    </div>
</body>

</html>
