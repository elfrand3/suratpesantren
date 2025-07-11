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
                                <input type="hidden" name="status" value="pending">
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
                                    <input type="hidden" name="santri_id" id="santri_id">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">NIS</label>
                                    <input type="text" id="nis-search"  autocomplete="off" placeholder="Cari Nomer Induk Santri..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Santri</label>
                                    <input type="text" id="nama_santri"  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                                    <i class="fas fa-file-alt text-blue-600 mr-2"></i> Tampilan Surat
                                </h3>
                                <div class="w-full min-h-[400px] max-h-[600px] border border-gray-300 rounded-md focus-within:ring-2 focus-within:ring-blue-500 bg-white relative">
                                    <div id="loadingIndicator" class="hidden absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
                                        <div class="text-center">
                                            <i class="fas fa-spinner fa-spin text-2xl text-blue-600 mb-2"></i>
                                            <p class="text-gray-600">Memuat template...</p>
                                        </div>
                                    </div>

                                    {{-- <div id="isiSurat"
                                        contenteditable="true"
                                        class="w-full min-h-[400px] border border-gray-300 rounded-md p-4 text-center font-serif leading-relaxed bg-white shadow"
                                        style="white-space: pre-wrap;">
                                    </div> --}}

                                    <textarea id="isiSurat" name="content" class="w-full min-h-[400px] border-0 focus:outline-none focus:ring-0 resize-none text-center" placeholder="Tulis isi surat di sini atau pilih template untuk memuat format surat..."></textarea>

                                    {{-- <div id="previewArea" class="mt-4 p-4 border border-gray-300 bg-white rounded shadow text-sm text-gray-800">
                                        <em>Preview surat akan tampil di sini...</em>
                                    </div> --}}

                                </div>
                                {{-- <input type="hidden" name="content" id="hiddenContent"> --}}

                                {{-- <textarea name="content" id="isiSuratHidden" class="hidden"></textarea> --}}
                            </div>
                            <!-- (4) Aksi Surat - Kanan Bawah -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h3 class="text-lg font-semibold text-blue-700 mb-4 flex items-center section-header">
                                    <i class="fas fa-tasks text-blue-600 mr-2"></i> Aksi Surat
                                </h3>
                                <div class="flex justify-end space-x-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Surat</label>
                                    <select id="jenisSurat" name="jenis_surat" onchange="loadTemplate()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="jenis-surat">jenis Surat</option>
                                        <option value="izin-pulang">Surat Izin Pulang</option>
                                        <option value="sakit">Surat Sakit</option>
                                        <option value="rekomendasi">Surat Rekomendasi</option>
                                        <option value="keterangan">Surat Keterangan</option>
                                        <option value="undangan">Surat Undangan</option>
                                    </select>
                                </div>
                                <br>
                                <div class="flex justify-end space-x-3">
                                    <button type="button" onclick="" class="px-6 py-2 bg-yellow-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                                    </button>
                                    <button type="button" onclick="previewSurat()" class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                                        <i class="fas fa-eye mr-2"></i> Preview
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

    {{-- @verbatim
    <script>
    let currentTemplate = ""; // menyimpan template mentah

    function loadTemplate() {
        const jenisSurat = document.getElementById("jenisSurat").value;

        fetch(`/get-template/${jenisSurat}`)
            .then(response => {
                if (!response.ok) throw new Error("Template tidak ditemukan.");
                return response.text();
            })
            .then(template => {
                currentTemplate = template;
                updateTextarea(); // isi textarea setelah menyimpan template
            })
            .catch(error => {
                document.getElementById("isiSurat").value = "silahkan pilih jenis template surat.";
                console.error(error);
            });
    }

    function injectFormValues(template) {
        const map = {
            nama_santri: document.getElementById('nama_santri').value,
            nis: document.getElementById('nis-search').value,
            alasan: document.getElementById('alasan').value,
            tanggal_surat: document.getElementById('tanggalSurat').value,
            tanggal_kembali: document.getElementById('tanggalKembali').value,
            diagnosa: document.getElementById('diagnosa').value,
            nomor_surat: document.getElementById('nomorSurat').value,
        };

        let result = template;
        for (const key in map) {
            const regex = new RegExp(`{{\\s*${key}\\s*}}`, 'g');
            result = result.replace(regex, map[key] || '');
        }

        return result;
    }

    function updateTextarea() {
        document.getElementById("isiSurat").value = injectFormValues(currentTemplate);
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Set event listener untuk semua input yang relevan
        ['nama_santri', 'nis-search', 'alasan', 'tanggalSurat', 'tanggalKembali', 'diagnosa', 'nomorSurat'].forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('input', updateTextarea);
            }
        });
    });
    </script>
    @endverbatim --}}

    {{-- @verbatim
    <script>
    function loadTemplate() {
        const jenisSurat = document.getElementById("jenisSurat").value;

        fetch(`/get-template/${jenisSurat}`)
            .then(response => {
                if (!response.ok) throw new Error("Template tidak ditemukan.");
                return response.text();
            })
            .then(template => {
                const result = injectFormValues(template);
                document.getElementById("isiSurat").innerText = result;
            })
            .catch(error => {
                document.getElementById("isiSurat").innerText = "Gagal memuat template surat.";
                console.error(error);
            });
    }

    function injectFormValues(template) {
        const map = {
            nama_santri: document.getElementById('nama_santri').value,
            nis: document.getElementById('nis-search').value,
            alasan: document.getElementById('alasan').value,
            tanggal_surat: document.getElementById('tanggalSurat').value,
            tanggal_kembali: document.getElementById('tanggalKembali').value,
            diagnosa: document.getElementById('diagnosa').value,
            nomor_surat: document.getElementById('nomorSurat').value,
        };

        let result = template;
        for (const key in map) {
            const regex = new RegExp(`{{\s*${key}\s*}}`, 'g');
            result = result.replace(regex, map[key] || '');
        }

        return result;
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#nama_santri, #nis-search, #alasan, #tanggalSurat, #tanggalKembali, #diagnosa, #nomorSurat').forEach(input => {
            input.addEventListener('input', () => {
                const currentTemplate = document.getElementById("isiSurat").innerText;
                document.getElementById("isiSurat").innerText = injectFormValues(currentTemplate);
            });
        });

        // Isi hidden content sebelum submit form
        const form = document.querySelector("form");
        if (form) {
            form.addEventListener("submit", function () {
                const isiSurat = document.getElementById("isiSurat").innerText.trim();
                document.getElementById("hiddenContent").value = isiSurat;
            });
        }
    });
    </script>
    @endverbatim --}}

{{-- <script>
    function previewSurat() {
        const isi = document.getElementById("isiSurat").value;
        document.getElementById("previewArea").innerHTML = isi.replace(/\n/g, "<br>");
    }
    </script> --}}

    @verbatim
    <script>
    function loadTemplate() {
        const jenisSurat = document.getElementById("jenisSurat").value;

        fetch(`/get-template/${jenisSurat}`)
            .then(response => {
                if (!response.ok) throw new Error("Template tidak ditemukan.");
                return response.text();
            })
            .then(template => {
                const result = injectFormValues(template);
                document.getElementById("isiSurat").value = result;
            })
            .catch(error => {
                document.getElementById("isiSurat").value = "Gagal memuat template surat.";
                console.error(error);
            });
    }

    function injectFormValues(template) {
        const map = {
            nama_santri: document.getElementById('nama_santri').value,
            nis: document.getElementById('nis-search').value,
            alasan: document.getElementById('alasan').value,
            tanggal_surat: document.getElementById('tanggalSurat').value,
            tanggal_kembali: document.getElementById('tanggalKembali').value,
            diagnosa: document.getElementById('diagnosa').value,
            nomor_surat: document.getElementById('nomorSurat').value,
        };

        let result = template;
        for (const key in map) {
            const regex = new RegExp(`{{\\s*${key}\\s*}}`, 'g');
            result = result.replace(regex, map[key] || '');
        }

        return result;
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#nama_santri, #nis-search, #alasan, #tanggalSurat, #tanggalKembali, #diagnosa, #nomorSurat').forEach(input => {
            input.addEventListener('input', () => {
                const currentTemplate = document.getElementById("isiSurat").value;
                document.getElementById("isiSurat").value = injectFormValues(currentTemplate);
            });
        });
    });
    </script>
    @endverbatim
    


    <script>
    function previewSurat() {
        const isi = document.getElementById("isiSurat").value;

        // Format isi surat ke HTML (mengganti newline ke <br>)
        const formattedIsi = isi.replace(/\n/g, "<br>");

        // Buat jendela baru
        const printWindow = window.open('', '_blank', 'width=800,height=600');

        // Tulis konten HTML lengkap ke jendela
        printWindow.document.write(`
            <html>
            <head>
                <title>Preview Surat</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                        line-height: 1.6;
                        color: #000;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                ${formattedIsi}
            </body>
            </html>
        `);

        printWindow.document.close(); // Penting agar konten siap diprint
        printWindow.focus();

        // Jalankan print
        printWindow.print();

        // Tutup jendela setelah print (opsional)
        printWindow.close();
    }
    </script>

<script>
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

    </script>

</body>
</html>
