<!DOCTYPE html>
<html lang="en" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>Data Santri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('components.sidebar')
    <div class="ml-72 pt-16">
        @include('components.navbar', ['title' => 'Data Santri'])
        <main class="p-6">
            <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Santri</h3>
                </div>
                <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Santri</label>
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Cari berdasarkan NIS, nama, kelas, alamat, tempat lahir, atau nama orang tua..." 
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="md:w-48">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kelas</label>
                            <select id="kelasFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Kelas</option>
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
                <div class="overflow-x-auto table-container">
                    <table class="min-w-full divide-y divide-gray-200 fixed-table">
                        <thead class="sticky-header">
                            <tr>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-no">No</th>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-nis">NIS</th>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-nama">Nama</th>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-kelas">Kelas</th>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-alamat">Alamat</th>
                                <th class="table-cell text-left text-xs font-medium text-gray-500 uppercase tracking-wider col-status">Status</th>
                                <th class="table-cell text-center text-xs font-medium text-gray-500 uppercase tracking-wider col-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="santriTableBody" class="bg-white divide-y divide-gray-200">
                            <!-- Data will be loaded dynamically -->
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex items-center justify-between text-sm text-gray-700">
                    <div id="paginationInfo">
                        Menampilkan <span id="startIndex">1</span> - <span id="endIndex">10</span> dari <span id="totalItems">0</span> santri
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
    <script>
// ... Copy all script logic dari admin, HAPUS seluruh fungsi/modal/addNewSantri, closeAddSantriModal, saveNewSantri, dan tombol tambah santri ...
// ... Sisakan hanya fitur search, filter, lihat, edit, hapus, pagination, notifikasi ...
    </script>
</body>
</html>