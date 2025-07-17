<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Izin Pulang</title>
    <link rel="stylesheet" href="{{ asset ('pdf.css')}}">
</head>

<body>
<!-- Header dengan logo dan nama pesantren -->
<div class="kop-header">
    <!-- Gambar di kiri -->
    <img src="{{ asset('logo.png') }}" alt="Logo" class="kop-logo">

    <!-- Teks institusi -->
    <div class="kop-teks text-uppercase">
        <strong>
            Pondok Pesantren<br>
            Mambaul Ulum<br>
            Kaliacar – Gading – Probolinggo
        </strong>
    </div>
</div>

<!-- Alamat dengan border -->
<p class="kop-alamat">
    Jl. KH. Asy’ari Kaliacar, Gading. Email: <i>doktren_mambaululum@yahoo.com</i>
    Tlp. 0831-1234-51485 Pos: 67285
</p>

    <div class="text-center">
        <strong>003/PP-MU/D4/09-2025</strong><br>
        <h2><u>SURAT IZIN {{ strtoupper($jenis_izin ?? 'PULANG') }}</u></h2>
    </div>
    <p class="text-center">Assalamualaikum Wr. Wb</p>
    <p>Dengan ini kami menyatakan bahwa nama Santri di bawah ini:</p>
    <p>
        Nama : {{ $santri->nama ?? '..................................................' }}<br>
        Alamat : {{ $santri->alamat ?? '..................................................' }}<br>
        Kamar : {{ $santri->kamar ?? '..................................................' }}
    </p>
    <p class="indent">
        Telah dinyatakan diberikan <strong>IZIN {{ strtoupper($jenis_izin ?? 'PULANG') }}</strong> <u>alasan</u>
        terhitung sejak tanggal:
        {{ $tanggal_mulai ?? '...' }} – {{ $tanggal_selesai ?? '...' }} M.<br>
        Batas waktu <strong>KEMBALI</strong> ke Pesantren pada tanggal:
        {{ $tanggal_selesai ?? '...' }}.
    </p>
    <p class="indent">
        Demikian surat ini kami buat dengan sebenar-benarnya agar diperhatikan dan dipatuhi dengan sebaik mungkin.
    </p>

    <div class="text-center">
        <div class="signature">
            <p><i>Wassalamualaikum Wr. Wb</i></p>
            <p>Kaliacar, {{ $tanggal_cetak ?? '___, ____________, 2025' }}</p>
            <p>Pengasuh Pesantren</p>
            <br><br><br>
            <p><strong>KH. As'ad Abu Hasan</strong></p>
        </div>
    </div>
</body>

</html>
