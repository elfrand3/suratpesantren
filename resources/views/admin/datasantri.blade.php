<!DOCTYPE html>
<html lang="en" translate="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>Data Santri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Ensure table has minimum width and stable columns */
        .table-container {
            min-width: 1200px;
            /* Minimum width to accommodate all columns */
        }

        /* Fixed column widths with consistent alignment */
        .col-no {
            width: 64px;
            min-width: 64px;
            max-width: 64px;
        }

        .col-nis {
            width: 128px;
            min-width: 128px;
            max-width: 128px;
        }

        .col-nama {
            width: 192px;
            min-width: 192px;
            max-width: 192px;
        }

        .col-kelas {
            width: 128px;
            min-width: 128px;
            max-width: 128px;
        }

        .col-alamat {
            width: 256px;
            min-width: 256px;
            max-width: 256px;
        }

        .col-status {
            width: 96px;
            min-width: 96px;
            max-width: 96px;
        }

        .col-aksi {
            width: 128px;
            min-width: 128px;
            max-width: 128px;
        }

        /* Ensure sticky header works properly */
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: rgb(250, 250, 250);
        }

        /* Consistent cell padding and alignment */
        .table-cell {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            box-sizing: border-box;
        }

        /* Ensure table layout is fixed for consistent column widths */
        .fixed-table {
            table-layout: fixed;
            width: 100%;
        }

        /* Prevent text overflow and ensure consistent alignment */
        .table-cell-content {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>

<body class="bg-gray-50">
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="ml-72 pt-16">
        @include('components.navbar', ['title' => 'Data Santri'])

        <main class="p-6">
            <!-- Box utama -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Santri</h3>
                    <button onclick="addNewSantri()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors flex items-center">
                        <i class="fas fa-user-plus mr-2"></i> Tambah Santri
                    </button>
                </div>
                <!-- Box filter/search -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <form id="formFilterSantri" method="GET" action="{{ route('admin.santri.list') }}">
                        <div class="flex flex-col md:flex-row gap-4 flex-wrap">
                            <div class="flex-1 min-w-[200px]">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Santri</label>
                                <div class="relative">
                                    <input type="text" name="q" id="searchInput"
                                        value="{{ isset($search) ? $search : '' }}"
                                        placeholder="Cari berdasarkan NIS, nama, kelas, alamat, tempat lahir, atau nama orang tua..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-48 min-w-[150px]">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                                <select id="statusFilter" name="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua Status</option>
                                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="Tidak Aktif"
                                        {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="md:w-48 min-w-[150px]">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kelas</label>
                                <select id="kelasFilter" name="kelas"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua Kelas</option>
                                    <option value="X IPA 1" {{ request('kelas') == 'X IPA 1' ? 'selected' : '' }}>X IPA
                                        1</option>
                                    <option value="X IPA 2" {{ request('kelas') == 'X IPA 2' ? 'selected' : '' }}>X IPA
                                        2</option>
                                    <option value="X IPA 3" {{ request('kelas') == 'X IPA 3' ? 'selected' : '' }}>X IPA
                                        3</option>
                                    <option value="X IPS 1" {{ request('kelas') == 'X IPS 1' ? 'selected' : '' }}>X IPS
                                        1</option>
                                    <option value="X IPS 2" {{ request('kelas') == 'X IPS 2' ? 'selected' : '' }}>X IPS
                                        2</option>
                                    <option value="XI IPA 1" {{ request('kelas') == 'XI IPA 1' ? 'selected' : '' }}>XI
                                        IPA 1</option>
                                    <option value="XI IPA 2" {{ request('kelas') == 'XI IPA 2' ? 'selected' : '' }}>XI
                                        IPA 2</option>
                                    <option value="XI IPS 1" {{ request('kelas') == 'XI IPS 1' ? 'selected' : '' }}>XI
                                        IPS 1</option>
                                    <option value="XI IPS 2" {{ request('kelas') == 'XI IPS 2' ? 'selected' : '' }}>XI
                                        IPS 2</option>
                                    <option value="XII IPA 1" {{ request('kelas') == 'XII IPA 1' ? 'selected' : '' }}>
                                        XII IPA 1</option>
                                    <option value="XII IPA 2" {{ request('kelas') == 'XII IPA 2' ? 'selected' : '' }}>
                                        XII IPA 2</option>
                                    <option value="XII IPS 1" {{ request('kelas') == 'XII IPS 1' ? 'selected' : '' }}>
                                        XII IPS 1</option>
                                    <option value="XII IPS 2" {{ request('kelas') == 'XII IPS 2' ? 'selected' : '' }}>
                                        XII IPS 2</option>
                                </select>
                            </div>
                            <div class="md:w-45 min-w-[150px]">
                                <label class="block text-sm font-medium text-transparent mb-2">Aksi</label>
                                <div class="flex items-center gap-2 justify-end">
                                    <button type="submit"
                                        class="ml-2 px-4 py-2 h-10 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center"
                                        title="Cari" style="min-width:40px;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="/admindatasantri"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors flex items-center">
                                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                    <!-- Search Results Info -->
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div id="searchResultsInfo" class="text-sm text-gray-600">
                                Menampilkan 0 dari 0 santri
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-lightbulb mr-1"></i>
                                    Tips: Gunakan kombinasi pencarian dan filter untuk hasil yang lebih akurat
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box tabel data santri -->
                <div class="bg-white rounded-lg shadow border border-gray-200 p-0">
                    <div class="overflow-x-auto w-full">
                        <table class="min-w-max w-full divide-y divide-gray-200 fixed-table">
                            <thead class="sticky-header">
                                <tr>
                                    <th
                                        class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-no">
                                        No</th>
                                    <th
                                        class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-nis">
                                        NIS</th>
                                    <th
                                        class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-nama">
                                        Nama</th>
                                    <th
                                        class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-kelas">
                                        Kelas</th>
                                    <th
                                        class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-alamat">
                                        Alamat</th>
                                    <th
                                        class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-status">
                                        Status</th>
                                    <th
                                        class="table-cell text-center text-xs font-medium text-gray-500 uppercase tracking-wider col-aksi">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($santris as $santri)
                                    <tr>
                                        <td class="table-cell col-no">
                                            <div class="table-cell-content">{{ $loop->iteration }}</div>
                                        </td>
                                        <td class="table-cell col-nis">
                                            <div class="table-cell-content font-medium text-gray-900">
                                                {{ $santri->nis }}</div>
                                        </td>
                                        <td class="table-cell col-nama">
                                            <div class="table-cell-content">{{ $santri->nama }}</div>
                                        </td>
                                        <td class="table-cell col-kelas">
                                            <div class="table-cell-content">{{ $santri->kelas }}</div>
                                        </td>
                                        <td class="table-cell col-alamat">
                                            <div class="table-cell-content">{{ $santri->alamat }}</div>
                                        </td>
                                        <td class="table-cell col-status">
                                            <div class="table-cell-content">
                                                <span
                                                    class="px-3 py-1 {{ $santri->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} text-xs rounded-full">
                                                    {{ $santri->status }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="table-cell col-aksi text-center">
                                            <div class="table-cell-content actions">
                                                <a href="{{ route('admin.santri.detail', $santri->id) }}"
                                                    class="text-blue-600 hover:text-blue-800 mr-2" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.santri.edit', $santri->id) }}"
                                                    class="text-yellow-600 hover:text-yellow-800 mr-2" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.santri.delete', $santri->id) }}"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800"
                                                        title="Hapus"
                                                        style="background:none; border:none; padding:0;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-search text-6xl mb-4 text-gray-300"></i>
                                                <h3 class="text-lg font-medium text-gray-700 mb-2">Belum ada data
                                                    santri tersimpan</h3>
                                                <p class="text-sm text-gray-500 mb-4">Tambah data santri untuk mulai
                                                    mengisi daftar</p>
                                                <button onClick="addNewSantri()"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                                    <i class="fas fa-plus mr-2"></i>Buat Data Pertama
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Info jumlah data -->
                <div class="mt-2 text-sm text-gray-700">
                    Menampilkan <span>{{ $santris->count() ? 1 : 0 }}</span> - <span>{{ $santris->count() }}</span>
                    dari <span>{{ $santris->count() }}</span> santri
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Profil -->
    <div id="profileModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Profil Admin</h3>
                <button onclick="closeProfileModal()" class="text-gray-500 hover:text-gray-700"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="flex items-center space-x-6 mb-6">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt="Admin" class="h-20 w-20 rounded-full">
                <div>
                    <h4 class="text-xl font-semibold text-gray-800">Administrator</h4>
                    <p class="text-gray-600">Admin Sistem Surat</p>
                    <p class="text-sm text-gray-500">Bergabung sejak Januari 2023</p>
                </div>
            </div>
            <form>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" value="Administrator"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" value="admin@pondok.com"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                        <input type="tel" value="081234567890"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                        <input type="text" value="Administrator Sistem"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        rows="3">Jl. Pondok Pesantren No. 123, Kecamatan Pondok, Kota Santri</textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeProfileModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Santri -->
    <div id="addSantriModal"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-md flex items-center justify-center z-50 transition-all duration-300 hidden">
        <div
            class="bg-white/80 rounded-2xl shadow-2xl border-2 border-blue-200 p-10 w-full max-w-4xl max-h-[90vh] overflow-y-auto transition-all duration-300">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold text-blue-800">Tambah Santri Baru</h3>
                <button onclick="closeAddSantriModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.santri.store') }}" method="POST" id="formTambahSantri"
                onsubmit="tambahSantri(event)">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Informasi Pribadi -->
                    <div class="md:col-span-2 mb-2">
                        <h4 class="text-lg font-semibold text-blue-700 mb-4 border-b-2 border-blue-100 pb-2">Informasi
                            Pribadi</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIS <span
                                class="text-red-500">*</span></label>
                        <input name="nis" type="text" id="newNis"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input name="nama" type="text" id="newNama"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tempat Lahir <span
                                class="text-red-500">*</span></label>
                        <input name="tempat_lahir" type="text" id="newTempatLahir"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Lahir <span
                                class="text-red-500">*</span></label>
                        <input name="tanggal_lahir" type="date" id="newTanggalLahir"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas <span
                                class="text-red-500">*</span></label>
                        <select id="newKelas" name="kelas"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            required>
                            <option value="">Pilih Kelas</option>
                            <option value="X IPA 1">X IPA 1</option>
                            <option value="X IPA 2">X IPA 2</option>
                            <option value="X IPA 3">X IPA 3</option>
                            <option value="X IPS 1">X IPS 1</option>
                            <option value="X IPS 2">X IPS 2</option>
                            <option value="XI IPA 1">XI IPA 1</option>
                            <option value="XI IPA 2">XI IPA 2</option>
                            <option value="XI IPS 1">XI IPS 1</option>
                            <option value="XI IPS 2">XI IPS 2</option>
                            <option value="XII IPA 1">XII IPA 1</option>
                            <option value="XII IPA 2">XII IPA 2</option>
                            <option value="XII IPS 1">XII IPS 1</option>
                            <option value="XII IPS 2">XII IPS 2</option>
                        </select>
                    </div>
                    <!-- Status (dari Informasi Akademik) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status <span
                                class="text-red-500">*</span></label>
                        <select id="newStatus" name="status"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            required>
                            <option value="">Pilih Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin <span
                                class="text-red-500">*</span></label>
                        <select id="newJenisKelamin" name="jenis_kelamin"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Agama <span
                                class="text-red-500">*</span></label>
                        <select id="newAgama" name="agama"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon <span
                                class="text-red-500">*</span></label>
                        <input type="tel" name="no_telp" id="newNoTelp"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat <span
                                class="text-red-500">*</span></label>
                        <textarea id="newAlamat" name="alamat"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            rows="3" required></textarea>
                    </div>
                    <!-- Informasi Orang Tua -->
                    <div class="md:col-span-2 mt-2 mb-2">
                        <h4 class="text-lg font-semibold text-blue-700 mb-4 border-b-2 border-blue-100 pb-2 mt-4">
                            Informasi Orang Tua</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Orang Tua <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_ortu" id="newNamaOrtu"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Orang Tua <span
                                class="text-red-500">*</span></label>
                        <textarea id="newAlamatOrtu" name="alamat_ortu"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/70"
                            rows="3" required></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-4 mt-8">
                    <button type="button" onclick="closeAddSantriModal()"
                        class="px-6 py-3 border-2 border-blue-200 rounded-xl bg-white/70 text-blue-700 font-semibold hover:bg-blue-50 transition-all">Batal</button>
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all shadow">
                        <i class="fas fa-save mr-2"></i>Simpan Santri
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Santri ala template surat -->
    <div id="deleteSantriModal"
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
            <div class="flex items-center mb-4">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Hapus</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Apakah Anda yakin ingin menghapus santri <strong id="deleteSantriName"></strong>?
                    <br><br>
                    <span class="text-red-600 font-medium">Tindakan ini tidak dapat dibatalkan!</span>
                </p>
                <div class="flex justify-center space-x-3">
                    <button onclick="closeDeleteSantriModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button onclick="confirmDeleteSantri()"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Santri -->
    <div id="modalDetailSantri"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <button onclick="closeModal('modalDetailSantri')"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></button>
            <h3 class="text-lg font-semibold mb-4">Detail Santri</h3>
            <div id="detailSantriContent">
                <!-- Data santri akan dimuat di sini -->
            </div>
        </div>
    </div>

    <!-- Modal Edit Santri (tanpa JS, langsung tampil jika $santriEdit ada) -->
    @if (isset($santriEdit))
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative max-h-[90vh] overflow-y-auto">
                <a href="{{ route('admin.santri.list') }}"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></a>
                <h3 class="text-lg font-semibold mb-4">Edit Data Santri</h3>
                <form action="{{ route('admin.santri.update', $santriEdit->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="nis" class="border rounded p-2" placeholder="NIS"
                            value="{{ $santriEdit->nis }}" required>
                        <input type="text" name="nama" class="border rounded p-2" placeholder="Nama"
                            value="{{ $santriEdit->nama }}" required>
                        <input type="text" name="tempat_lahir" class="border rounded p-2"
                            placeholder="Tempat Lahir" value="{{ $santriEdit->tempat_lahir }}" required>
                        <input type="date" name="tanggal_lahir" class="border rounded p-2"
                            value="{{ $santriEdit->tanggal_lahir }}" required>
                        <input type="text" name="jenis_kelamin" class="border rounded p-2"
                            placeholder="Jenis Kelamin" value="{{ $santriEdit->jenis_kelamin }}" required>
                        <input type="text" name="agama" class="border rounded p-2" placeholder="Agama"
                            value="{{ $santriEdit->agama }}" required>
                        <input type="text" name="kelas" class="border rounded p-2" placeholder="Kelas"
                            value="{{ $santriEdit->kelas }}" required>
                        <input type="text" name="status" class="border rounded p-2" placeholder="Status"
                            value="{{ $santriEdit->status }}" required>
                        <input type="text" name="alamat" class="border rounded p-2" placeholder="Alamat"
                            value="{{ $santriEdit->alamat }}" required>
                        <input type="text" name="no_telp" class="border rounded p-2" placeholder="No Telp"
                            value="{{ $santriEdit->no_telp }}" required>
                        <input type="text" name="nama_ortu" class="border rounded p-2" placeholder="Nama Ortu"
                            value="{{ $santriEdit->nama_ortu }}" required>
                        <input type="text" name="alamat_ortu" class="border rounded p-2"
                            placeholder="Alamat Ortu" value="{{ $santriEdit->alamat_ortu }}" required>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Notification Container (for elegant stacked notifications) -->
    <div id="notificationContainer"
        class="fixed top-20 right-8 z-[9999] flex flex-col items-end space-y-3 w-full max-w-xs sm:max-w-sm pointer-events-none">
    </div>

    @if (isset($santriDetail))
        <!-- Modal Detail Santri (tanpa JS, langsung tampil jika $santriDetail ada) -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                <a href="{{ route('admin.santri.list') }}"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></a>
                <h3 class="text-lg font-semibold mb-4">Detail Data Santri</h3>
                <table class="w-full text-sm">
                    <tr>
                        <td class="font-semibold">NIS</td>
                        <td>{{ $santriDetail->nis }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Nama</td>
                        <td>{{ $santriDetail->nama }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Tempat, Tanggal Lahir</td>
                        <td>{{ $santriDetail->tempat_lahir }}, {{ $santriDetail->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Jenis Kelamin</td>
                        <td>{{ $santriDetail->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Agama</td>
                        <td>{{ $santriDetail->agama }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Kelas</td>
                        <td>{{ $santriDetail->kelas }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Status</td>
                        <td>{{ $santriDetail->status }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Alamat</td>
                        <td>{{ $santriDetail->alamat }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">No Telp</td>
                        <td>{{ $santriDetail->no_telp }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Nama Ortu</td>
                        <td>{{ $santriDetail->nama_ortu }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Alamat Ortu</td>
                        <td>{{ $santriDetail->alamat_ortu }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif

    <script>
        function addNewSantri() {
            var modal = document.getElementById('addSantriModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeAddSantriModal() {
            var modal = document.getElementById('addSantriModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }
    </script>
</body>

</html>
