<!DOCTYPE html>
<html lang="en" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>Daftar Surat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('components.sidebar')
    <div class="ml-72 pt-16">
        @include('components.navbar', ['title' => 'Daftar Surat'])
        <main class="p-6">
            <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Surat</h3>
                </div>
                <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Surat</label>
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Cari berdasarkan nomor surat, jenis surat, NIS, perihal, atau nama santri..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Tekan Enter untuk mencari atau gunakan filter di bawah
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                <i class="fas fa-keyboard mr-1"></i>
                                Shortcut: Ctrl+F untuk fokus, Esc untuk refresh
                            </p>
                        </div>
                        <div class="md:w-48">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Jenis Surat</label>
                            <select id="jenisSuratFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Jenis</option>
                                <option value="izin-pulang">Surat Izin Pulang</option>
                                <option value="sakit">Surat Sakit</option>
                                <option value="rekomendasi">Surat Rekomendasi</option>
                                <option value="keterangan">Surat Keterangan</option>
                                <option value="undangan">Surat Undangan</option>
                            </select>
                        </div>
                        <div class="md:w-48">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="Draft">Draft</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dikirim">Dikirim</option>
                            </select>
                        </div>
                        <div class="md:w-48">
                            <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                            <button onclick="refreshData()" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-sync-alt mr-2"></i>Refresh
                            </button>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div id="searchResultsInfo" class="text-sm text-gray-600">
                                Menampilkan 0 dari 0 surat
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
                <div class="overflow-x-auto table-container">
                    <table class="min-w-full divide-y divide-gray-200 fixed-table">
                        <thead class="sticky-header">
                            <tr>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-no">No</th>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-nomor">Nomor Surat</th>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-jenis">Jenis Surat</th>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-tanggal">Tanggal</th>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-nis">NIS</th>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-perihal">Perihal</th>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-status">Status</th>
                                <th class="table-cell text-center text-xs font-medium text-gray-500 uppercase tracking-wider col-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="letterTableBody" class="bg-white divide-y divide-gray-200">
                            <!-- Data will be loaded dynamically -->
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex items-center justify-between text-sm text-gray-700">
                    <div id="paginationInfo">
                        Menampilkan <span id="startIndex">1</span> - <span id="endIndex">10</span> dari <span id="totalItems">0</span> surat
                    </div>
                    <div class="flex space-x-2">
                        <button id="prevPage" onclick="previousPage()" class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-chevron-left mr-1"></i>Sebelumnya
                        </button>
                        <button id="nextPage" onclick="nextPage()" class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            Selanjutnya<i class="fas fa-chevron-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="notificationContainer" class="fixed top-20 right-8 z-[9999] flex flex-col items-end space-y-3 w-full max-w-xs sm:max-w-sm pointer-events-none"></div>
    <!-- Modal Detail Surat -->
    <div id="letterDetailModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Detail Surat</h3>
                <button onclick="closeLetterDetailModal()" class="text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></button>
            </div>
            <div id="letterDetailContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="flex justify-end space-x-2 mt-6">
                <button onclick="printLetter()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                    <i class="fas fa-print mr-2"></i>Cetak
                </button>
                <button onclick="closeLetterDetailModal()" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">Tutup</button>
            </div>
        </div>
    </div>
    <script>
// ... Copy all script logic dari admin, HAPUS seluruh fungsi/tombol/modal pembuatan surat baru ...
// ... Sisakan hanya fitur search, filter, lihat, detail, cetak, pagination, notifikasi ...
    </script>
</body>
</html>