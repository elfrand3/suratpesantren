<!DOCTYPE html>
<html lang="en" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Surat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- TinyMCE Configuration -->
    <x-head.tinymce-config/>
    <link rel="stylesheet" href="{{ asset('scrib/scrib.css') }}">
    <script src="{{ asset('scrib/scrib.js') }}"></script>
    <style>
        /* Custom styles for auto-resizing editor */
        .tox-tinymce {
            border: none !important;
            box-shadow: none !important;
        }
        
        .tox .tox-edit-area {
            border: none !important;
        }
        
        .tox .tox-edit-area__iframe {
            background: transparent !important;
        }
        
        #isiSurat {
            transition: height 0.3s ease;
        }
        
        /* Ensure content area has proper padding */
        .tox .tox-edit-area__iframe {
            padding: 10px !important;
        }
        
        /* Remove resize handle */
        .tox .tox-statusbar__resize-handle {
            display: none !important;
        }
        
        /* Hide status bar to remove resize functionality */
        .tox .tox-statusbar {
            display: none !important;
        }
        
        /* Ensure proper border styling */
        #isiSurat:focus-within {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1) !important;
        }
        
        /* Smooth transitions for height changes */
        .tox .tox-edit-area {
            transition: height 0.3s ease !important;
        }
        
        /* Layout improvements */
        .form-section {
            transition: all 0.3s ease;
        }
        
        .form-section:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        /* Responsive improvements */
        @media (max-width: 1024px) {
            .lg\:grid-cols-3 {
                grid-template-columns: 1fr;
            }
            
            .lg\:col-span-1,
            .lg\:col-span-2 {
                grid-column: span 1;
            }
        }
        
        /* Section headers */
        .section-header {
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        
        /* Field grouping */
        .field-group {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        /* Diagnosa field animation */
        #diagnosaField {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        #diagnosaField.hidden {
            max-height: 0;
            opacity: 0;
            margin: 0;
            padding: 0;
        }
        
        #diagnosaField:not(.hidden) {
            max-height: 100px;
            opacity: 1;
        }
        
        /* Info area styling */
        #infoArea {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        #infoArea.hidden {
            max-height: 0;
            opacity: 0;
            margin: 0;
            padding: 0;
        }
        
        #infoArea:not(.hidden) {
            max-height: 200px;
            opacity: 1;
        }
        
        #infoArea .bg-blue-50 {
            border-left: 4px solid #3b82f6;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="ml-72 pt-16">
        @include('components.navbar', ['title' => 'Buat Surat'])

        <!-- Form Buat Surat -->
        <main class="p-6">
            <div class="w-full max-w-7xl bg-white rounded-lg shadow-lg p-8 border border-gray-200 mx-auto mt-10 mb-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-plus-circle text-blue-600 mr-3"></i> Formulir Pembuatan Surat
                </h2>
                <form class="space-y-6" method="POST" action="{{ route('admin.surat.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- (1) Data Surat - Kiri -->
                        <div class="lg:col-span-1 space-y-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Template Surat</label>
                                    <select id="templateSurat" name="template_surat" onchange="loadTemplateFromDropdown()" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih Template</option>
                                        <option value="izin-pulang">Template Izin Pulang</option>
                                        <option value="sakit">Template Sakit</option>
                                        <option value="rekomendasi">Template Rekomendasi</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <strong>Pemilihan Template:</strong> Pilih template untuk memuat format surat secara otomatis ke dalam editor
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Template Database</label>
                                    <select id="templateDatabase" name="template_database" onchange="loadDatabaseTemplate()" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih Template dari Database</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-database mr-1"></i>
                                        <strong>Template Database:</strong> Template yang telah diupload dan disimpan di database
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Surat</label>
                                    <select id="jenisSurat" name="jenis_surat" onchange="loadTemplate()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih Jenis Surat</option>
                                        <option value="izin-pulang">Surat Izin Pulang</option>
                                        <option value="sakit">Surat Sakit</option>
                                        <option value="rekomendasi">Surat Rekomendasi</option>
                                        <option value="keterangan">Surat Keterangan</option>
                                        <option value="undangan">Surat Undangan</option>
                                    </select>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Surat</label>
                                        <input type="text" id="nomorSurat" name="nomor_surat" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="001/SURAT/2024">
                                    </div>
                                    
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Surat</label>
                                        <input type="date" id="tanggalSurat" name="tanggal_surat" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>                                
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kembali</label>
                                        <input type="date" id="tanggalKembali" name="tanggal_kembali" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>                                    
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">NIS</label>
                                    <input type="text" id="nis-search" name="nis" autocomplete="off" placeholder="Cari Nomer Induk Santri..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Santri</label>
                                    <input type="text" id="nama_santri" name="nama_santri" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <input type="hidden" id="santri_id" name="santri_id">
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Alasan</label>
                                        <input type="text" id="alasan" name="alasan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan alasan surat">
                                    </div>
                                    <button type="button" onclick="fillAlasanOtomatis(document.getElementById('jenisSurat').value)" class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors mt-6" title="Isi Otomatis Alasan">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Diagnosa</label>
                                        <input type="text" id="diagnosa" name="diagnosa" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan diagnosa penyakit (opsional)">
                                    </div>
                                    <button type="button" onclick="fillDiagnosaOtomatis()" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors mt-6" title="Isi Otomatis Diagnosa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- (2) Isi Surat - Kanan Atas -->
                        <div class="lg:col-span-2">
                            <div class="bg-white p-4 rounded-lg border border-gray-200 mb-6">
                                <h3 class="text-lg font-semibold text-blue-700 mb-4 flex items-center section-header">
                                    <i class="fas fa-file-alt text-blue-600 mr-2"></i> Isi Surat
                                </h3>
                                <div class="w-full min-h-[400px] max-h-[600px] border border-gray-300 rounded-md focus-within:ring-2 focus-within:ring-blue-500 bg-white relative">
                                    <div id="loadingIndicator" class="hidden absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
                                        <div class="text-center">
                                            <i class="fas fa-spinner fa-spin text-2xl text-blue-600 mb-2"></i>
                                            <p class="text-gray-600">Memuat template...</p>
                                        </div>
                                    </div>
                                    <textarea id="isiSurat" name="content" class="w-full min-h-[400px] border-0 focus:outline-none focus:ring-0 resize-none" placeholder="Tulis isi surat di sini atau pilih template untuk memuat format surat..."></textarea>
                                </div>
                                <textarea name="content" id="isiSuratHidden" class="hidden"></textarea>
                            </div>
                            <!-- (3) Pengaturan Surat - Kanan Tengah -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                                <h3 class="text-lg font-semibold text-blue-700 mb-4 flex items-center section-header">
                                    <i class="fas fa-cog text-blue-600 mr-2"></i> Pengaturan Surat
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran</label>
                                        <input type="file" name="file_surat" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="" disabled selected hidden>Pilih</option>
                                            <option value="Menunggu Persetujuan">Menunggu Persetujuan</option>
                                            <option value="Di setujui">Di setujui</option>
                                            <option value="Di tolak">Di tolak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- (4) Aksi Surat - Kanan Bawah -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h3 class="text-lg font-semibold text-blue-700 mb-4 flex items-center section-header">
                                    <i class="fas fa-tasks text-blue-600 mr-2"></i> Aksi Surat
                                </h3>
                                <div class="flex justify-end space-x-3">
                                    <button type="button" onclick="fillTemplatePlaceholders()" class="px-6 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition-colors">
                                        <i class="fas fa-magic mr-2"></i> Isi Otomatis
                                    </button>
                                    <button type="button" onclick="previewSurat()" class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                                        <i class="fas fa-eye mr-2"></i> Preview
                                    </button>
                                    <button type="button" onclick="simpanDraft()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                                        Simpan Draft
                                    </button>
                                    <button type="button" onclick="printSurat()" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                        <i class="fas fa-print mr-2"></i> Cetak
                                    </button>
                                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                        Kirim Surat
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Modal Profil -->
    <div id="profileModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Profil Admin</h3>
                <button onclick="closeProfileModal()" class="text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></button>
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
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-900">Administrator</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-900">admin@pondok.com</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                        <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-900">081234567890</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                        <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-900">Administrator Sistem</div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-900">Jl. Pondok Pesantren No. 123, Kecamatan Pondok, Kota Santri</div>
                </div>
                <div class="flex justify-end space-x-2 pt-4">
                    <button onclick="goToSettings()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-cog mr-2"></i>Pengaturan
                    </button>
                    <button onclick="closeProfileModal()" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // TinyMCE sudah diinisialisasi di komponen tinymce-config
        // Tidak perlu inisialisasi ulang di sini

        // Function to resize editor after content changes
        function resizeEditor() {
            const editor = tinymce.get('isiSurat');
            if (editor) {
                editor.execCommand('mceAutoResize');
            }
        }

        // Resize editor when window is resized
        window.addEventListener('resize', function() {
            setTimeout(function() {
                resizeEditor();
            }, 100);
        });

        // Template content functions (from templatesurat.blade.php)
        function getIzinPulangTemplate() {
            return `<div style="text-align: center; margin-bottom: 20px;">
    <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">SURAT IZIN PULANG</h2>
    <p style="font-size: 14px;">Nomor: [NOMOR_SURAT]</p>
</div>

<div style="margin-bottom: 20px;">
    <p style="text-align: justify; line-height: 1.6;">
        Yang bertanda tangan di bawah ini, Kepala Pondok Pesantren [NAMA_PONDOK], 
        memberikan izin kepada:
    </p>
</div>

<div style="margin-bottom: 20px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 150px; padding: 5px 0;">Nama</td>
            <td style="padding: 5px 0;">: [NAMA_SANTRI]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Kelas</td>
            <td style="padding: 5px 0;">: [KELAS]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Alamat</td>
            <td style="padding: 5px 0;">: [ALAMAT]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Tanggal Izin</td>
            <td style="padding: 5px 0;">: [TANGGAL_IZIN]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Alasan</td>
            <td style="padding: 5px 0;">: [ALASAN]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Diagnosa</td>
            <td style="padding: 5px 0;">: [DIAGNOSA]</td>
        </tr>
    </table>
</div>

<div style="margin-bottom: 20px;">
    <p style="text-align: justify; line-height: 1.6;">
        <strong>DENGAN INI DIIZINKAN PULANG</strong> ke rumah untuk mendapatkan perawatan medis 
        dan istirahat yang diperlukan. Santri diharapkan kembali ke pondok pesantren 
        pada tanggal [TANGGAL_KEMBALI] dalam keadaan sehat dan siap mengikuti kegiatan pembelajaran.
    </p>
</div>

<div style="margin-bottom: 20px;">
    <p style="text-align: justify; line-height: 1.6;">
        <strong>Keterangan:</strong> Surat ini dikeluarkan berdasarkan kondisi kesehatan santri 
        yang memerlukan perawatan di rumah dan pengawasan keluarga.
    </p>
</div>

<div style="margin-top: 40px; text-align: right;">
    <p>[TEMPAT], [TANGGAL_SURAT]</p>
    <p style="margin-top: 50px;">[NAMA_KEPALA_PONDOK]</p>
    <p>Kepala Pondok Pesantren</p>
</div>`;
        }

        function getSakitTemplate() {
            return `<div style="text-align: center; margin-bottom: 20px;">
    <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">SURAT KETERANGAN SAKIT</h2>
    <p style="font-size: 14px;">Nomor: [NOMOR_SURAT]</p>
</div>

<div style="margin-bottom: 20px;">
    <p style="text-align: justify; line-height: 1.6;">
        Yang bertanda tangan di bawah ini, Kepala Pondok Pesantren [NAMA_PONDOK], 
        menerangkan bahwa:
    </p>
</div>

<div style="margin-bottom: 20px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 150px; padding: 5px 0;">Nama</td>
            <td style="padding: 5px 0;">: [NAMA_SANTRI]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Kelas</td>
            <td style="padding: 5px 0;">: [KELAS]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Alamat</td>
            <td style="padding: 5px 0;">: [ALAMAT]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Tanggal Sakit</td>
            <td style="padding: 5px 0;">: [TANGGAL_SAKIT]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Diagnosa</td>
            <td style="padding: 5px 0;">: [DIAGNOSA]</td>
        </tr>
    </table>
</div>

<div style="margin-bottom: 20px;">
    <p style="text-align: justify; line-height: 1.6;">
        Benar-benar sedang dalam keadaan sakit dan tidak dapat mengikuti kegiatan 
        pembelajaran di pondok pesantren.
    </p>
</div>

<div style="margin-top: 40px; text-align: right;">
    <p>[TEMPAT], [TANGGAL_SURAT]</p>
    <p style="margin-top: 50px;">[NAMA_KEPALA_PONDOK]</p>
    <p>Kepala Pondok Pesantren</p>
</div>`;
        }

        function getRekomendasiTemplate() {
            return `<div style="text-align: center; margin-bottom: 20px;">
    <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">SURAT REKOMENDASI</h2>
    <p style="font-size: 14px;">Nomor: [NOMOR_SURAT]</p>
</div>

<div style="margin-bottom: 20px;">
    <p style="text-align: justify; line-height: 1.6;">
        Yang bertanda tangan di bawah ini, Kepala Pondok Pesantren [NAMA_PONDOK], 
        memberikan rekomendasi kepada:
    </p>
</div>

<div style="margin-bottom: 20px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 150px; padding: 5px 0;">Nama</td>
            <td style="padding: 5px 0;">: [NAMA_SANTRI]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Tempat/Tanggal Lahir</td>
            <td style="padding: 5px 0;">: [TEMPAT_LAHIR], [TANGGAL_LAHIR]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Kelas</td>
            <td style="padding: 5px 0;">: [KELAS]</td>
        </tr>
        <tr>
            <td style="padding: 5px 0;">Alamat</td>
            <td style="padding: 5px 0;">: [ALAMAT]</td>
        </tr>
    </table>
</div>

<div style="margin-bottom: 20px;">
    <p style="text-align: justify; line-height: 1.6;">
        Adalah santri yang telah menempuh pendidikan di pondok pesantren kami 
        dengan prestasi akademik dan akhlak yang baik. Santri tersebut memiliki 
        kemampuan dan karakter yang layak untuk [TUJUAN_REKOMENDASI].
    </p>
</div>

<div style="margin-bottom: 20px;">
    <p style="text-align: justify; line-height: 1.6;">
        Oleh karena itu, kami merekomendasikan santri tersebut untuk [TUJUAN_REKOMENDASI] 
        dan berharap dapat diterima dengan baik.
    </p>
</div>

<div style="margin-top: 40px; text-align: right;">
    <p>[TEMPAT], [TANGGAL_SURAT]</p>
    <p style="margin-top: 50px;">[NAMA_KEPALA_PONDOK]</p>
    <p>Kepala Pondok Pesantren</p>
</div>`;
        }

        function getSakitIzinPulangTemplate() {
            return `<div style="text-align: center; margin-bottom: 20px;">
                <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">SURAT IZIN PULANG</h2>
                <p style="font-size: 14px;">Nomor: [NOMOR_SURAT]</p>
            </div>

            <div style="margin-bottom: 20px;">
                <p style="text-align: justify; line-height: 1.6;">
                    Yang bertanda tangan di bawah ini, Kepala Pondok Pesantren [NAMA_PONDOK], 
                    memberikan izin kepada:
                </p>
            </div>

            <div style="margin-bottom: 20px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 150px; padding: 5px 0;">Nama</td>
                        <td style="padding: 5px 0;">: [NAMA_SANTRI]</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">Kelas</td>
                        <td style="padding: 5px 0;">: [KELAS]</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">Alamat</td>
                        <td style="padding: 5px 0;">: [ALAMAT]</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">Tanggal Izin</td>
                        <td style="padding: 5px 0;">: [TANGGAL_IZIN]</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">Diagnosa</td>
                        <td style="padding: 5px 0;">: [DIAGNOSA]</td>
                    </tr>
                </table>
            </div>

            <div style="margin-bottom: 20px;">
                <p style="text-align: justify; line-height: 1.6;">
                    <strong>DENGAN INI DIIZINKAN PULANG</strong> ke rumah untuk mendapatkan perawatan medis 
                    dan istirahat yang diperlukan. Santri diharapkan kembali ke pondok pesantren 
                    pada tanggal [TANGGAL_KEMBALI] dalam keadaan sehat dan siap mengikuti kegiatan pembelajaran.
                </p>
            </div>

            <div style="margin-bottom: 20px;">
                <p style="text-align: justify; line-height: 1.6;">
                    <strong>Keterangan:</strong> Surat ini dikeluarkan berdasarkan kondisi kesehatan santri 
                    yang memerlukan perawatan di rumah dan pengawasan keluarga.
                </p>
            </div>

            <div style="margin-top: 40px; text-align: right;">
                <p>[TEMPAT], [TANGGAL_SURAT]</p>
                <p style="margin-top: 50px;">[NAMA_KEPALA_PONDOK]</p>
                <p>Kepala Pondok Pesantren</p>
            </div>`;
        }

        // Load template based on selection
        function loadTemplate() {
            const jenisSurat = document.getElementById('jenisSurat').value;
            const templateSurat = document.getElementById('templateSurat').value;
            
            console.log('loadTemplate called - jenisSurat:', jenisSurat, 'templateSurat:', templateSurat);
            
            // If jenis surat is selected, automatically select the corresponding template
            if (jenisSurat && !templateSurat) {
                const templateMap = {
                    'izin-pulang': 'izin-pulang',
                    'sakit': 'sakit',
                    'rekomendasi': 'rekomendasi',
                    'keterangan': 'izin-pulang', // Use izin-pulang template for keterangan
                    'undangan': 'izin-pulang'    // Use izin-pulang template for undangan
                };
                
                if (templateMap[jenisSurat]) {
                    document.getElementById('templateSurat').value = templateMap[jenisSurat];
                    showNotification(`Template ${templateMap[jenisSurat]} otomatis dipilih untuk ${jenisSurat}`, 'info');
                }
            }
            
            // If template is selected first, filter jenis surat options
            if (templateSurat && !jenisSurat) {
                filterJenisSuratOptions(templateSurat);
            }
            
            // Auto-fill form fields based on jenis surat
            if (jenisSurat) {
                fillAlasanOtomatis(jenisSurat);
                fillTanggalKembaliOtomatis(jenisSurat);
            }
            
            // Show special information based on combination
            const finalTemplate = templateSurat || (jenisSurat ? templateMap[jenisSurat] : '');
            showSpecialInfo(finalTemplate, jenisSurat);
            
            // Handle alasan field state based on combination
            handleAlasanFieldState(finalTemplate, jenisSurat);
            
            // Load template content based on jenis surat or template selection
            let templateContent = '';
            let templateName = '';
            
            const selectedTemplate = templateSurat || (jenisSurat ? templateMap[jenisSurat] : '');
            
            console.log('Selected template:', selectedTemplate);
            
            switch(selectedTemplate) {
                case 'izin-pulang':
                    templateContent = getIzinPulangTemplate();
                    templateName = 'Template Izin Pulang';
                    break;
                case 'sakit':
                    templateContent = getSakitTemplate();
                    templateName = 'Template Sakit';
                    break;
                case 'rekomendasi':
                    templateContent = getRekomendasiTemplate();
                    templateName = 'Template Rekomendasi';
                    break;
                default:
                    console.log('No template selected, returning');
                    return; // Don't load anything if no template selected
            }
            
            // Load template into TinyMCE editor
            if (templateContent) {
                console.log('Loading template content into TinyMCE');
                showLoadingIndicator();
                ensureTinyMCEReady(() => {
                    const editor = tinymce.get('isiSurat');
                    if (editor) {
                        editor.setContent(templateContent);
                        setTimeout(function() {
                            resizeEditor();
                            hideLoadingIndicator();
                        }, 100);
                        showNotification(`${templateName} berhasil dimuat! Silakan isi data yang diperlukan.`, 'success');
                        
                        // Scroll to the editor to show the loaded content
                        const editorElement = document.getElementById('isiSurat');
                        if (editorElement) {
                            editorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    } else {
                        console.error('TinyMCE editor not found');
                        hideLoadingIndicator();
                        showNotification('Editor tidak tersedia, silakan refresh halaman', 'error');
                    }
                });
            }
        }

        // Function to ensure TinyMCE is ready before loading templates
        function ensureTinyMCEReady(callback) {
            if (typeof tinymce === 'undefined') {
                console.error('TinyMCE is not loaded');
                return;
            }
            
            const editor = tinymce.get('isiSurat');
            if (editor && editor.initialized) {
                callback();
            } else {
                // Wait for TinyMCE to be ready
                setTimeout(() => {
                    ensureTinyMCEReady(callback);
                }, 100);
            }
        }

        // Function to show/hide loading indicator
        function showLoadingIndicator() {
            const indicator = document.getElementById('loadingIndicator');
            if (indicator) {
                indicator.classList.remove('hidden');
            }
        }

        function hideLoadingIndicator() {
            const indicator = document.getElementById('loadingIndicator');
            if (indicator) {
                indicator.classList.add('hidden');
            }
        }

        // Function to load template directly when template dropdown changes
        function loadTemplateFromDropdown() {
            const templateSurat = document.getElementById('templateSurat').value;
            console.log('Template dropdown changed to:', templateSurat);
            
            if (templateSurat) {
                // Show loading indicator
                showLoadingIndicator();
                showNotification('Memuat template...', 'info');
                
                let templateContent = '';
                let templateName = '';
                
                switch(templateSurat) {
                    case 'izin-pulang':
                        templateContent = getIzinPulangTemplate();
                        templateName = 'Template Izin Pulang';
                        break;
                    case 'sakit':
                        templateContent = getSakitTemplate();
                        templateName = 'Template Sakit';
                        break;
                    case 'rekomendasi':
                        templateContent = getRekomendasiTemplate();
                        templateName = 'Template Rekomendasi';
                        break;
                    default:
                        hideLoadingIndicator();
                        return;
                }
                
                // Load template into TinyMCE editor
                if (templateContent) {
                    console.log('Loading template content into TinyMCE from dropdown');
                    ensureTinyMCEReady(() => {
                        const editor = tinymce.get('isiSurat');
                        if (editor) {
                            editor.setContent(templateContent);
                            setTimeout(function() {
                                resizeEditor();
                                hideLoadingIndicator();
                            }, 100);
                            showNotification(`${templateName} berhasil dimuat! Silakan isi data yang diperlukan.`, 'success');
                            
                            // Scroll to the editor to show the loaded content
                            const editorElement = document.getElementById('isiSurat');
                            if (editorElement) {
                                editorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        } else {
                            console.error('TinyMCE editor not found');
                            hideLoadingIndicator();
                            showNotification('Editor tidak tersedia, silakan refresh halaman', 'error');
                        }
                    });
                } else {
                    hideLoadingIndicator();
                }
            } else {
                hideLoadingIndicator();
            }
        }

        // Auto-fill alasan based on jenis surat
        function fillAlasanOtomatis(jenisSurat) {
            const alasanField = document.getElementById('alasan');
            const templateSurat = document.getElementById('templateSurat').value;
            let alasanText = '';
            
            // Skip auto-fill alasan for template sakit + jenis surat izin pulang
            if (templateSurat === 'sakit' && jenisSurat === 'izin-pulang') {
                alasanField.value = '';
                return;
            }
            
            // Array of reasons for each type
            const alasanList = {
                'izin-pulang': [
                    'Keperluan keluarga yang mendesak dan memerlukan kehadiran santri di rumah',
                    'Acara keluarga yang penting dan tidak dapat ditinggalkan',
                    'Kunjungan orang tua yang sudah lama tidak bertemu',
                    'Urusan keluarga yang memerlukan kehadiran santri'
                ],
                'sakit': [
                    'Sedang dalam keadaan sakit dan memerlukan istirahat serta perawatan medis',
                    'Mengalami gangguan kesehatan yang memerlukan pengobatan',
                    'Kondisi fisik yang tidak memungkinkan untuk mengikuti kegiatan pondok',
                    'Memerlukan pemeriksaan kesehatan di rumah sakit'
                ],
                'rekomendasi': [
                    'Untuk keperluan melanjutkan pendidikan ke jenjang yang lebih tinggi',
                    'Untuk mendaftar ke perguruan tinggi atau institusi pendidikan',
                    'Untuk keperluan beasiswa atau program khusus',
                    'Untuk keperluan administrasi akademik'
                ],
                'keterangan': [
                    'Untuk keperluan administrasi dan pengurusan dokumen resmi',
                    'Untuk keperluan pembuatan KTP atau dokumen kependudukan',
                    'Untuk keperluan pengurusan beasiswa atau bantuan sosial',
                    'Untuk keperluan verifikasi data santri'
                ],
                'undangan': [
                    'Untuk menghadiri acara keluarga yang penting dan tidak dapat ditinggalkan',
                    'Untuk menghadiri pernikahan atau acara adat keluarga',
                    'Untuk menghadiri acara keagamaan keluarga',
                    'Untuk menghadiri acara khusus keluarga'
                ]
            };
            
            if (alasanList[jenisSurat]) {
                // Randomly select one reason from the list
                const randomIndex = Math.floor(Math.random() * alasanList[jenisSurat].length);
                alasanText = alasanList[jenisSurat][randomIndex];
            }
            
            if (alasanText) {
                alasanField.value = alasanText;
                showNotification('Alasan berhasil diisi otomatis!', 'success');
            }
        }

        // Auto-fill tanggal kembali based on jenis surat
        function fillTanggalKembaliOtomatis(jenisSurat) {
            const tanggalKembaliField = document.getElementById('tanggalKembali');
            
            // Calculate return date based on letter type
            const today = new Date();
            let returnDate = new Date();
            
            switch(jenisSurat) {
                case 'izin-pulang':
                    returnDate.setDate(today.getDate() + 7); // 7 days from today
                    break;
                case 'sakit':
                    returnDate.setDate(today.getDate() + 3); // 3 days from today
                    break;
                case 'rekomendasi':
                    returnDate.setDate(today.getDate() + 1); // 1 day from today
                    break;
                case 'keterangan':
                    returnDate.setDate(today.getDate() + 2); // 2 days from today
                    break;
                case 'undangan':
                    returnDate.setDate(today.getDate() + 5); // 5 days from today
                    break;
                default:
                    returnDate.setDate(today.getDate() + 7); // Default 7 days
            }
            
            // Format date to YYYY-MM-DD for input field
            const formattedDate = returnDate.toISOString().split('T')[0];
            tanggalKembaliField.value = formattedDate;
            showNotification('Tanggal kembali berhasil diisi otomatis!', 'success');
        }

        // Filter jenis surat options based on selected template
        function filterJenisSuratOptions(templateSurat) {
            const jenisSuratSelect = document.getElementById('jenisSurat');
            const currentValue = jenisSuratSelect.value;
            
            // Store all original options
            if (!jenisSuratSelect.originalOptions) {
                jenisSuratSelect.originalOptions = Array.from(jenisSuratSelect.options);
            }
            
            // Clear current options
            jenisSuratSelect.innerHTML = '';
            
            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Pilih Jenis Surat';
            jenisSuratSelect.appendChild(defaultOption);
            
            // Show all options regardless of template selection
            const availableOptions = [
                { value: 'izin-pulang', text: 'Surat Izin Pulang' },
                { value: 'sakit', text: 'Surat Sakit' },
                { value: 'rekomendasi', text: 'Surat Rekomendasi' },
                { value: 'keterangan', text: 'Surat Keterangan' },
                { value: 'undangan', text: 'Surat Undangan' }
            ];
            
            // Add all options
            availableOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.value;
                optionElement.textContent = option.text;
                jenisSuratSelect.appendChild(optionElement);
            });
            
            // Restore current value if it's still available
            if (currentValue && availableOptions.some(opt => opt.value === currentValue)) {
                jenisSuratSelect.value = currentValue;
            } else {
                jenisSuratSelect.value = '';
            }
            
            // Show notification
            if (templateSurat) {
                const templateNames = {
                    'sakit': 'Template Sakit',
                    'izin-pulang': 'Template Izin Pulang',
                    'rekomendasi': 'Template Rekomendasi'
                };
                const templateName = templateNames[templateSurat] || templateSurat;
                showNotification(`${templateName} dipilih - semua jenis surat tersedia`, 'info');
            } else {
                showNotification(`Semua jenis surat tersedia`, 'info');
            }
        }

        // Reset jenis surat options to show all options
        function resetJenisSuratOptions() {
            const jenisSuratSelect = document.getElementById('jenisSurat');
            
            // Clear current options
            jenisSuratSelect.innerHTML = '';
            
            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Pilih Jenis Surat';
            jenisSuratSelect.appendChild(defaultOption);
            
            // Add all original options
            const allOptions = [
                { value: 'izin-pulang', text: 'Surat Izin Pulang' },
                { value: 'sakit', text: 'Surat Sakit' },
                { value: 'rekomendasi', text: 'Surat Rekomendasi' },
                { value: 'keterangan', text: 'Surat Keterangan' },
                { value: 'undangan', text: 'Surat Undangan' }
            ];
            
            allOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.value;
                optionElement.textContent = option.text;
                jenisSuratSelect.appendChild(optionElement);
            });
            
            showNotification(`Semua jenis surat tersedia`, 'info');
        }

        // Reset template selection and show all jenis surat options
        function resetTemplate() {
            // Clear template selection
            document.getElementById('templateSurat').value = '';
            
            // Reset jenis surat options to show all
            resetJenisSuratOptions();
            
            // Clear editor content
            tinymce.get('isiSurat').setContent('');
            
            // Clear form fields
            document.getElementById('diagnosa').value = '';
            document.getElementById('alasan').value = '';
            document.getElementById('tanggalKembali').value = '';
            
            // Hide special info area
            showSpecialInfo('', '');
            
            // Enable alasan field
            handleAlasanFieldState('', '');
            
            showNotification('Template berhasil direset!', 'success');
        }

        // Auto-fill diagnosa with common medical conditions
        function fillDiagnosaOtomatis() {
            const diagnosaField = document.getElementById('diagnosa');
            const diagnosaList = [
                'Demam dan flu dengan suhu 38.5°C',
                'Infeksi saluran pernapasan atas (ISPA) dengan batuk dan pilek',
                'Gastroenteritis dengan muntah dan diare akut',
                'Sakit kepala tegang (tension headache)',
                'Migrain dengan mual dan fotofobia',
                'Alergi rinitis dengan bersin dan hidung tersumbat',
                'Infeksi kulit (dermatitis) dengan ruam dan gatal',
                'Kelemahan dan kelelahan ekstrem',
                'Gangguan pencernaan (dispepsia)',
                'Sakit gigi dengan pembengkakan gusi',
                'Cedera ringan pada ekstremitas',
                'Hipertensi dengan tekanan darah 140/90 mmHg',
                'Diabetes mellitus dengan gula darah tinggi',
                'Asma dengan sesak napas dan mengi',
                'Anemia defisiensi besi',
                'Gangguan tidur (insomnia)',
                'Vertigo dengan pusing berputar',
                'Konjungtivitis dengan mata merah dan berair',
                'Otitis media dengan nyeri telinga',
                'Faringitis dengan nyeri tenggorokan'
            ];
            
            // Randomly select one diagnosa
            const randomIndex = Math.floor(Math.random() * diagnosaList.length);
            const diagnosaText = diagnosaList[randomIndex];
            
            diagnosaField.value = diagnosaText;
            showNotification('Diagnosa berhasil diisi otomatis!', 'success');
        }

        // Auto-fill template placeholders with form data
        function fillTemplatePlaceholders() {
            const nomorSurat = document.getElementById('nomorSurat').value;
            const tanggalSurat = document.getElementById('tanggalSurat').value;
            const tanggalKembali = document.getElementById('tanggalKembali').value;
            const nis = document.getElementById('nis-search').value;
            const alasan = document.getElementById('alasan').value;
            const diagnosa = document.getElementById('diagnosa').value;
            const jenisSurat = document.getElementById('jenisSurat').value;
            const templateSurat = document.getElementById('templateSurat').value;
            
            if (!nomorSurat || !tanggalSurat) {
                showNotification('Mohon isi Nomor Surat dan Tanggal Surat terlebih dahulu!', 'error');
                return;
            }
            
            // Validate tanggal kembali
            if (tanggalKembali && tanggalSurat) {
                const suratDate = new Date(tanggalSurat);
                const kembaliDate = new Date(tanggalKembali);
                
                if (kembaliDate <= suratDate) {
                    showNotification('Tanggal kembali harus lebih besar dari tanggal surat!', 'error');
                    return;
                }
            }
            
            // Validate diagnosa for sakit letter
            if (jenisSurat === 'sakit' && !diagnosa.trim()) {
                showNotification('Mohon isi diagnosa untuk surat sakit!', 'error');
                return;
            }
            
            let content = tinymce.get('isiSurat').getContent();
            
            // Replace placeholders with form data
            content = content.replace(/\[NOMOR_SURAT\]/g, nomorSurat);
            content = content.replace(/\[TANGGAL_SURAT\]/g, formatDate(tanggalSurat));
            content = content.replace(/\[TANGGAL_KEMBALI\]/g, tanggalKembali ? formatDate(tanggalKembali) : '[TANGGAL_KEMBALI]');
            content = content.replace(/\[NAMA_SANTRI\]/g, getSantriName(nis) || '[NAMA_SANTRI]');
            content = content.replace(/\[KELAS\]/g, getSantriClass(nis) || '[KELAS]');
            content = content.replace(/\[ALAMAT\]/g, getSantriAddress(nis) || '[ALAMAT]');
            content = content.replace(/\[ALASAN\]/g, alasan || '[ALASAN]');
            content = content.replace(/\[DIAGNOSA\]/g, diagnosa || '[DIAGNOSA]');
            content = content.replace(/\[TEMPAT\]/g, 'Pondok Pesantren');
            content = content.replace(/\[NAMA_KEPALA_PONDOK\]/g, 'K.H. Ahmad Dahlan');
            content = content.replace(/\[NAMA_PONDOK\]/g, 'Pondok Pesantren Al-Hikmah');
            
            // Set current date for other date fields
            const today = new Date();
            const todayFormatted = formatDate(today.toISOString().split('T')[0]);
            content = content.replace(/\[TANGGAL_IZIN\]/g, todayFormatted);
            content = content.replace(/\[TANGGAL_SAKIT\]/g, todayFormatted);
            
            tinymce.get('isiSurat').setContent(content);
            setTimeout(function() {
                resizeEditor();
            }, 100);
            showNotification('Data template berhasil diisi otomatis!', 'success');
        }

        // Helper function to format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('id-ID', options);
        }

        // Helper functions to get santri data (mock data)
        function getSantriName(nis) {
            const santriData = {
                '2121400097': 'Ahmad Fadillah',
                '2121400090': 'Muhammad Rizki',
                '2121400091': 'Fatimah Azzahra',
                '2121400092': 'Abdullah Rahman'
            };
            return santriData[nis] || null;
        }

        function getSantriClass(nis) {
            const santriData = {
                '2121400097': 'Kelas 2A',
                '2121400090': 'Kelas 1B',
                '2121400091': 'Kelas 3A',
                '2121400092': 'Kelas 2B'
            };
            return santriData[nis] || null;
        }

        function getSantriAddress(nis) {
            const santriData = {
                '2121400097': 'Jl. Merdeka No. 123, Jakarta',
                '2121400090': 'Jl. Sudirman No. 45, Bandung',
                '2121400091': 'Jl. Gatot Subroto No. 67, Surabaya',
                '2121400092': 'Jl. Thamrin No. 89, Medan'
            };
            return santriData[nis] || null;
        }

        // Show notification function
        function showNotification(message, type = 'info') {
            let container = document.getElementById('notificationContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'notificationContainer';
                container.className = 'fixed top-20 right-8 z-[9999] flex flex-col items-end space-y-3 w-full max-w-xs sm:max-w-sm pointer-events-none';
                document.body.appendChild(container);
            }
            // Remove existing notifications
            const existingNotifications = container.querySelectorAll('.notification');
            existingNotifications.forEach(notification => notification.remove());
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full opacity-0 pointer-events-auto ${
                type === 'success' ? 'bg-green-500 text-white' : 
                type === 'error' ? 'bg-red-500 text-white' : 
                type === 'warning' ? 'bg-yellow-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.textContent = message;
            container.appendChild(notification);
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
                notification.style.opacity = '1';
            }, 100);
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Preview surat function
        function previewSurat() {
            const content = tinymce.get('isiSurat').getContent();
            const jenisSurat = document.getElementById('jenisSurat').value;
            const templateSurat = document.getElementById('templateSurat').value;
            const diagnosa = document.getElementById('diagnosa').value.trim();
            
            if (!content.trim()) {
                showNotification('Isi surat masih kosong!', 'error');
                return;
            }
            
            // Validate diagnosa for sakit letter
            if (jenisSurat === 'sakit' && !diagnosa) {
                showNotification('Diagnosa wajib diisi untuk surat sakit!', 'error');
                return;
            }
            
            // Create preview window
            const previewWindow = window.open('', '_blank', 'width=800,height=600');
            previewWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Preview Surat</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
                        .preview-header { text-align: center; margin-bottom: 30px; }
                        .preview-content { margin-bottom: 30px; }
                        .preview-footer { text-align: right; margin-top: 50px; }
                        table { width: 100%; border-collapse: collapse; }
                        td { padding: 5px 0; }
                        @media print { body { margin: 20px; } }
                    </style>
                </head>
                <body>
                    <div class="preview-content">
                        ${content}
                    </div>
                    <div class="preview-footer">
                        <button onclick="window.print()">Cetak</button>
                        <button onclick="window.close()">Tutup</button>
                    </div>
                </body>
                </html>
            `);
            previewWindow.document.close();
        }

        // Print surat function
        function printSurat() {
            const content = tinymce.get('isiSurat').getContent();
            const jenisSurat = document.getElementById('jenisSurat').value;
            const templateSurat = document.getElementById('templateSurat').value;
            const diagnosa = document.getElementById('diagnosa').value.trim();
            
            if (!content.trim()) {
                showNotification('Isi surat masih kosong!', 'error');
                return;
            }
            
            // Validate diagnosa for sakit letter
            if (jenisSurat === 'sakit' && !diagnosa) {
                showNotification('Diagnosa wajib diisi untuk surat sakit!', 'error');
                return;
            }
            
            // Create print window
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Cetak Surat</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
                        @media print { 
                            body { margin: 20px; }
                            .no-print { display: none; }
                        }
                        table { width: 100%; border-collapse: collapse; }
                        td { padding: 5px 0; }
                    </style>
                </head>
                <body>
                    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
                        <button onclick="window.print()" style="padding: 10px 20px; margin: 5px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer;">Cetak</button>
                        <button onclick="window.close()" style="padding: 10px 20px; margin: 5px; background: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer;">Tutup</button>
                    </div>
                    <div>
                        ${content}
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
            
            // Auto-print after a short delay
            setTimeout(() => {
                printWindow.print();
            }, 500);
        }

        // Simpan Draft function
        function simpanDraft() {
            // Collect form data
            const nomorSurat = document.getElementById('nomorSurat').value.trim();
            const tanggalSurat = document.getElementById('tanggalSurat').value;
            const tanggalKembali = document.getElementById('tanggalKembali').value;
            const nis = document.getElementById('nis-search').value.trim();
            const alasan = document.getElementById('alasan').value.trim();
            const diagnosa = document.getElementById('diagnosa').value.trim();
            const jenisSurat = document.getElementById('jenisSurat').value;
            const templateSurat = document.getElementById('templateSurat').value;
            const content = tinymce.get('isiSurat').getContent();
            
            // Basic validation
            if (!jenisSurat) {
                showNotification('Pilih jenis surat terlebih dahulu!', 'error');
                return;
            }
            
            if (!templateSurat) {
                showNotification('Pilih template surat terlebih dahulu!', 'error');
                return;
            }
            
            if (!content.trim()) {
                showNotification('Isi surat masih kosong!', 'error');
                return;
            }
            
            // Validate diagnosa for sakit letter
            if (jenisSurat === 'sakit' && !diagnosa) {
                showNotification('Diagnosa wajib diisi untuk surat sakit!', 'error');
                return;
            }
            
            // Generate nomor surat if empty
            let finalNomorSurat = nomorSurat;
            if (!finalNomorSurat) {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                const randomNum = Math.floor(Math.random() * 999) + 1;
                finalNomorSurat = `${String(randomNum).padStart(3, '0')}/SURAT/${year}`;
            }
            
            // Set tanggal surat to today if empty
            let finalTanggalSurat = tanggalSurat;
            if (!finalTanggalSurat) {
                finalTanggalSurat = new Date().toISOString().split('T')[0];
            }
            
            // Prepare letter data
            const letterData = {
                nomorSurat: finalNomorSurat,
                jenisSurat: jenisSurat,
                templateSurat: templateSurat,
                tanggalSurat: finalTanggalSurat,
                tanggalKembali: tanggalKembali,
                nis: nis,
                namaSantri: getSantriName(nis) || 'N/A',
                alasan: alasan,
                diagnosa: diagnosa,
                content: content,
                status: 'Draft',
                createdAt: new Date().toISOString(),
                perihal: generatePerihal(jenisSurat, alasan, diagnosa)
            };
            
            // Save to localStorage (simulating database storage)
            saveDraftToStorage(letterData);
            
            // Show success notification
            showNotification('Draft surat berhasil disimpan!', 'success');
            
            // Optionally redirect to letter list
            setTimeout(() => {
                if (confirm('Draft berhasil disimpan! Apakah Anda ingin melihat daftar surat?')) {
                    window.location.href = '/admindaftarpembuatsurat';
                }
            }, 1000);
        }
        
        // Helper function to generate perihal based on letter type and content
        function generatePerihal(jenisSurat, alasan, diagnosa) {
            const jenisSuratMap = {
                'izin-pulang': 'Surat Izin Pulang',
                'sakit': 'Surat Sakit',
                'rekomendasi': 'Surat Rekomendasi',
                'keterangan': 'Surat Keterangan',
                'undangan': 'Surat Undangan'
            };
            
            let perihal = jenisSuratMap[jenisSurat] || 'Surat';
            
            if (alasan) {
                perihal += ` - ${alasan.substring(0, 50)}${alasan.length > 50 ? '...' : ''}`;
            } else if (diagnosa) {
                perihal += ` - ${diagnosa.substring(0, 50)}${diagnosa.length > 50 ? '...' : ''}`;
            }
            
            return perihal;
        }
        
        // Save draft to localStorage (simulating database)
        function saveDraftToStorage(letterData) {
            try {
                // Get existing drafts
                let drafts = JSON.parse(localStorage.getItem('letterDrafts') || '[]');
                
                // Add new draft
                drafts.push(letterData);
                
                // Save back to localStorage
                localStorage.setItem('letterDrafts', JSON.stringify(drafts));
                
                console.log('Draft saved:', letterData);
                console.log('Total drafts:', drafts.length);
                
            } catch (error) {
                console.error('Error saving draft:', error);
                showNotification('Gagal menyimpan draft!', 'error');
            }
        }

        // Profile dropdown functions
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close profile dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const profileButton = event.target.closest('button[onclick="toggleProfileDropdown()"]');
            
            if (!profileButton && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Logout function
        function logout() {
            showLogoutConfirmation();
        }

        // Show elegant logout confirmation modal
        function showLogoutConfirmation() {
            // Create modal overlay
            const modalOverlay = document.createElement('div');
            modalOverlay.id = 'logoutModalOverlay';
            modalOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-[9999]';
            
            // Create modal content
            const modalContent = document.createElement('div');
            modalContent.className = 'bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0';
            modalContent.innerHTML = `
                <div class=\"text-center\">\n                    <div class=\"mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6\">\n                        <i class=\"fas fa-sign-out-alt text-2xl text-red-600\"></i>\n                    </div>\n                    <h3 class=\"text-xl font-bold text-gray-900 mb-4\">Konfirmasi Keluar</h3>\n                    <p class=\"text-gray-600 mb-8\">Apakah Anda yakin ingin keluar dari sistem? Semua data yang belum disimpan akan hilang.</p>\n                    <div class=\"flex space-x-4\">\n                        <button onclick=\"cancelLogout()\" class=\"flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium\">\n                            Batal\n                        </button>\n                        <button onclick=\"confirmLogout()\" class=\"flex-1 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium\">\n                            <i class=\"fas fa-sign-out-alt mr-2\"></i>Keluar\n                        </button>\n                    </div>\n                </div>\n            `;
            
            modalOverlay.appendChild(modalContent);
            document.body.appendChild(modalOverlay);
            
            // Animate modal in
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 100);
            
            // Close dropdown if open
            document.getElementById('profileDropdown').classList.add('hidden');
        }

        // Cancel logout
        function cancelLogout() {
            const modalOverlay = document.getElementById('logoutModalOverlay');
            const modalContent = modalOverlay.querySelector('div');
            
            // Animate modal out
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                document.body.removeChild(modalOverlay);
            }, 300);
        }

        // Confirm logout
        function confirmLogout() {
            const modalOverlay = document.getElementById('logoutModalOverlay');
            const modalContent = modalOverlay.querySelector('div');
            
            // Show loading state
            modalContent.innerHTML = `
                <div class=\"text-center\">\n                    <div class=\"mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-6\">\n                        <i class=\"fas fa-spinner fa-spin text-2xl text-blue-600\"></i>\n                    </div>\n                    <h3 class=\"text-xl font-bold text-gray-900 mb-4\">Memproses...</h3>\n                    <p class=\"text-gray-600\">Sedang keluar dari sistem...</p>\n                </div>\n            `;
            
            // Show notification if function exists
            if (typeof showNotification === 'function') {
                showNotification('Sedang keluar dari sistem...', 'info');
            }
            
            setTimeout(() => {
                // Clear login data
                localStorage.removeItem('loginData');
                sessionStorage.removeItem('loginData');
                
                // Show success notification if function exists
                if (typeof showNotification === 'function') {
                    showNotification('Berhasil keluar dari sistem!', 'success');
                }
                
                // Redirect to logout page with role parameter
                setTimeout(() => {
                    window.location.href = '/logout?role=admin';
                }, 1000);
            }, 800);
        }

        // Close logout modal when clicking outside
        document.addEventListener('click', function(event) {
            const modalOverlay = document.getElementById('logoutModalOverlay');
            if (modalOverlay && event.target === modalOverlay) {
                cancelLogout();
            }
        });

        // Close logout modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modalOverlay = document.getElementById('logoutModalOverlay');
                if (modalOverlay) {
                    cancelLogout();
                }
            }
        });

        // Profile modal functions
        function openProfileModal() {
            document.getElementById('profileModal').classList.remove('hidden');
            document.getElementById('profileDropdown').classList.add('hidden');
        }

        function closeProfileModal() {
            document.getElementById('profileModal').classList.add('hidden');
        }

        // Settings modal functions
        function openSettingsModal() {
            window.location.href = '/p';
            document.getElementById('profileDropdown').classList.add('hidden');
        }

        // Go to settings function
        function goToSettings() {
            window.location.href = '/p';
            closeProfileModal();
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = ['profileModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        }

        const santriList = [
            "2121400097",
            "2121400090",
            "2121400091",
            "2121400092"
        ];
        const input = document.getElementById('nis-search');
        const results = document.getElementById('nis-results');

        input.addEventListener('input', function() {
            const value = this.value.trim();
            results.innerHTML = '';
            if (value.length === 0) {
                results.classList.add('hidden');
                return;
            }
            const filtered = santriList.filter(nis => nis.includes(value));
            if (filtered.length === 0) {
                results.classList.add('hidden');
                return;
            }
            filtered.forEach(nis => {
                const li = document.createElement('li');
                li.textContent = nis;
                li.className = 'px-4 py-2 cursor-pointer hover:bg-blue-100';
                li.addEventListener('click', function() {
                    input.value = nis;
                    results.classList.add('hidden');
                });
                results.appendChild(li);
            });
            results.classList.remove('hidden');
        });
        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !results.contains(e.target)) {
                results.classList.add('hidden');
            }
        });

        // Initialize page state
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize filter based on current template selection
            const templateSurat = document.getElementById('templateSurat').value;
            const jenisSurat = document.getElementById('jenisSurat').value;
            
            if (templateSurat) {
                filterJenisSuratOptions(templateSurat);
            }
            
            // Show special info if both template and jenis surat are selected
            if (templateSurat && jenisSurat) {
                showSpecialInfo(templateSurat, jenisSurat);
            }
        });

        // Validate form before submission
        function validateForm() {
            const jenisSurat = document.getElementById('jenisSurat').value;
            const templateSurat = document.getElementById('templateSurat').value;
            
            if (!jenisSurat) {
                showNotification('Pilih jenis surat terlebih dahulu!', 'error');
                return false;
            }
            
            if (!templateSurat) {
                showNotification('Pilih template surat terlebih dahulu!', 'error');
                return false;
            }
            
            // Validate diagnosa for sakit letter
            if (jenisSurat === 'sakit') {
                const diagnosa = document.getElementById('diagnosa').value.trim();
                if (!diagnosa) {
                    showNotification('Diagnosa wajib diisi untuk surat sakit!', 'error');
                    return false;
                }
            }
            
            return true;
        }

        // Show special information based on combination
        function showSpecialInfo(templateSurat, jenisSurat) {
            const infoArea = document.getElementById('infoArea');
            const infoText = document.getElementById('infoText');
            
            // Hide info area by default
            infoArea.classList.add('hidden');
            
            // Show information based on jenis surat
            if (jenisSurat === 'izin-pulang') {
                infoText.innerHTML = `
                    <strong>Surat Izin Pulang:</strong><br>
                    • Santri diizinkan pulang untuk keperluan keluarga atau kesehatan<br>
                    • Diagnosa opsional (bisa diisi jika ada alasan kesehatan)<br>
                    • Tanggal kembali akan dihitung 7 hari dari tanggal surat<br>
                    • Surat ini untuk keperluan keluarga atau acara penting
                `;
                infoArea.classList.remove('hidden');
            } else if (jenisSurat === 'sakit') {
                infoText.innerHTML = `
                    <strong>Surat Sakit:</strong><br>
                    • Santri sedang dalam keadaan sakit<br>
                    • Diagnosa wajib diisi untuk keperluan medis<br>
                    • Tanggal kembali akan dihitung 3 hari dari tanggal surat<br>
                    • Surat ini untuk keperluan administrasi medis
                `;
                infoArea.classList.remove('hidden');
            } else if (jenisSurat === 'rekomendasi') {
                infoText.innerHTML = `
                    <strong>Surat Rekomendasi:</strong><br>
                    • Surat untuk keperluan akademik atau administrasi<br>
                    • Diagnosa tidak diperlukan untuk surat ini<br>
                    • Tanggal kembali akan dihitung 1 hari dari tanggal surat<br>
                    • Surat ini untuk keperluan pendidikan atau beasiswa
                `;
                infoArea.classList.remove('hidden');
            } else if (jenisSurat === 'keterangan') {
                infoText.innerHTML = `
                    <strong>Surat Keterangan:</strong><br>
                    • Surat untuk keperluan administrasi dan pengurusan dokumen resmi<br>
                    • Diagnosa tidak diperlukan untuk surat ini<br>
                    • Tanggal kembali akan dihitung 2 hari dari tanggal surat<br>
                    • Surat ini untuk keperluan verifikasi data santri
                `;
                infoArea.classList.remove('hidden');
            } else if (jenisSurat === 'undangan') {
                infoText.innerHTML = `
                    <strong>Surat Undangan:</strong><br>
                    • Surat untuk menghadiri acara keluarga yang penting<br>
                    • Diagnosa tidak diperlukan untuk surat ini<br>
                    • Tanggal kembali akan dihitung 5 hari dari tanggal surat<br>
                    • Surat ini untuk keperluan acara keluarga atau acara khusus
                `;
                infoArea.classList.remove('hidden');
            }
        }

        // Handle alasan field state based on combination
        function handleAlasanFieldState(templateSurat, jenisSurat) {
            const alasanField = document.getElementById('alasan');
            // Always enable alasan field
            alasanField.disabled = false;
        }

        // Enhanced form validation and submission
        function validateForm() {
            // Get form values
            const nomorSurat = document.getElementById('nomorSurat').value.trim();
            const jenisSurat = document.getElementById('jenisSurat').value;
            const tanggalSurat = document.getElementById('tanggalSurat').value;
            const nis = document.getElementById('nis-search').value.trim();
            const namaSantri = document.getElementById('nama_santri').value.trim();
            const perihal = document.querySelector('input[name="perihal"]').value.trim();
            const status = document.querySelector('select[name="status"]').value;
            
            // Basic validation
            if (!nomorSurat) {
                showNotification('Nomor surat harus diisi!', 'error');
                return false;
            }
            
            if (!jenisSurat) {
                showNotification('Jenis surat harus dipilih!', 'error');
                return false;
            }
            
            if (!tanggalSurat) {
                showNotification('Tanggal surat harus diisi!', 'error');
                return false;
            }
            
            if (!nis) {
                showNotification('NIS harus diisi!', 'error');
                return false;
            }
            
            if (!namaSantri) {
                showNotification('Nama santri harus diisi!', 'error');
                return false;
            }
            
            if (!perihal) {
                showNotification('Perihal surat harus diisi!', 'error');
                return false;
            }
            
            if (!status) {
                showNotification('Status surat harus dipilih!', 'error');
                return false;
            }
            
            // Get content from TinyMCE
            const content = tinymce.get('isiSurat').getContent();
            document.getElementById('isiSuratHidden').value = content;
            
            if (!content || content.trim() === '') {
                showNotification('Isi surat harus diisi!', 'error');
                return false;
            }
            
            // Validate diagnosa for sakit letter
            if (jenisSurat === 'sakit') {
                const diagnosa = document.getElementById('diagnosa').value.trim();
                if (!diagnosa) {
                    showNotification('Diagnosa wajib diisi untuk surat sakit!', 'error');
                    return false;
                }
            }
            
            return true;
        }

        // Enhanced NIS search with AJAX
        function searchSantriByNis(nis) {
            fetch('{{ route("admin.surat.search-santri") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ nis: nis })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('nama_santri').value = data.santri.nama;
                    document.getElementById('santri_id').value = data.santri.id;
                    // Show success message
                    showNotification('Data santri ditemukan: ' + data.santri.nama, 'success');
                } else {
                    document.getElementById('nama_santri').value = '';
                    document.getElementById('santri_id').value = '';
                    showNotification('Santri dengan NIS ' + nis + ' tidak ditemukan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat mencari data santri', 'error');
            });
        }

        // Generate nomor surat automatically
        function generateNomorSurat() {
            const jenisSurat = document.getElementById('jenisSurat').value;
            if (!jenisSurat) {
                showNotification('Pilih jenis surat terlebih dahulu!', 'error');
                return;
            }
            
            fetch('{{ route("admin.surat.generate-nomor") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ jenis_surat: jenisSurat })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('nomorSurat').value = data.nomor_surat;
                showNotification('Nomor surat berhasil digenerate: ' + data.nomor_surat, 'success');
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat generate nomor surat', 'error');
            });
        }

        // Update NIS search to use AJAX
        document.getElementById('nis-search').addEventListener('blur', function() {
            const nis = this.value.trim();
            if (nis) {
                searchSantriByNis(nis);
            }
        });
        // Notification function
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'} text-white`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Simpan isi TinyMCE ke textarea sebelum kirim
        document.querySelector('form').addEventListener('submit', function (e) {
            // Prevent default submission if validation fails
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
            
            // Save TinyMCE content to hidden textarea
            const isiSurat = tinymce.get('isiSurat').getContent();
            document.getElementById('isiSuratHidden').value = isiSurat;
            
            // Show loading notification
            showNotification('Menyimpan surat...', 'info');
        });

        // Fungsi validasi dasar (tidak digunakan, sudah diganti dengan validateForm yang lebih lengkap)
        function validateFormBasic() {
            // Tambahkan validasi sesuai kebutuhan
            return true; // Jika semua valid
        }

        // Load database templates on page load
        function loadDatabaseTemplates() {
            fetch('/admin/templates/get/list')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = document.getElementById('templateDatabase');
                        select.innerHTML = '<option value="">Pilih Template dari Database</option>';
                        
                        data.templates.forEach(template => {
                            const option = document.createElement('option');
                            option.value = template.id;
                            option.textContent = `${template.nama_template} (${template.jenis_surat})`;
                            option.dataset.content = template.content_html || '';
                            select.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading database templates:', error);
                });
        }

        // Load template from database
        function loadDatabaseTemplate() {
            const templateId = document.getElementById('templateDatabase').value;
            if (!templateId) return;

            const select = document.getElementById('templateDatabase');
            const selectedOption = select.options[select.selectedIndex];
            const contentHtml = selectedOption.dataset.content;

            if (contentHtml) {
                showLoadingIndicator();
                showNotification('Memuat template dari database...', 'info');
                
                ensureTinyMCEReady(() => {
                    const editor = tinymce.get('isiSurat');
                    if (editor) {
                        editor.setContent(contentHtml);
                        setTimeout(function() {
                            resizeEditor();
                            hideLoadingIndicator();
                        }, 100);
                        showNotification('Template database berhasil dimuat!', 'success');
                        
                        // Scroll to the editor to show the loaded content
                        const editorElement = document.getElementById('isiSurat');
                        if (editorElement) {
                            editorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    } else {
                        hideLoadingIndicator();
                        showNotification('Editor tidak tersedia, silakan refresh halaman', 'error');
                    }
                });
            } else {
                // If no HTML content, fetch from server
                fetch(`/admin/templates/${templateId}/content`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.content_html) {
                            showLoadingIndicator();
                            showNotification('Memuat template dari database...', 'info');
                            
                            ensureTinyMCEReady(() => {
                                const editor = tinymce.get('isiSurat');
                                if (editor) {
                                    editor.setContent(data.content_html);
                                    setTimeout(function() {
                                        resizeEditor();
                                        hideLoadingIndicator();
                                    }, 100);
                                    showNotification('Template database berhasil dimuat!', 'success');
                                    
                                    // Scroll to the editor to show the loaded content
                                    const editorElement = document.getElementById('isiSurat');
                                    if (editorElement) {
                                        editorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    }
                                } else {
                                    hideLoadingIndicator();
                                    showNotification('Editor tidak tersedia, silakan refresh halaman', 'error');
                                }
                            });
                        } else {
                            showNotification('Template tidak memiliki konten HTML', 'warning');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading template content:', error);
                        showNotification('Gagal memuat template dari database', 'error');
                    });
            }
        }

        // Initialize page state
        document.addEventListener('DOMContentLoaded', function() {
            // Load database templates
            loadDatabaseTemplates();
            
            // Initialize filter based on current template selection
            const templateSurat = document.getElementById('templateSurat').value;
            const jenisSurat = document.getElementById('jenisSurat').value;
            
            if (templateSurat) {
                filterJenisSuratOptions(templateSurat);
            }
            
            // Show special info if both template and jenis surat are selected
            if (templateSurat && jenisSurat) {
                showSpecialInfo(templateSurat, jenisSurat);
            }
        });

        // TinyMCE sudah diinisialisasi di atas, tidak perlu Scrib editor
        // document.addEventListener('DOMContentLoaded', function() {
        //     initScribEditor('isiSurat');
        // });
    </script>
</body>
</html>