<!DOCTYPE html>
<html lang="en" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>Daftar Pembuat Surat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="ml-72 pt-16">
        @include('components.navbar', ['title' => 'Daftar Pembuat Surat'])

        <!-- Table Daftar Surat -->
        <main class="p-6">
            <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Surat</h3>
                    <!-- DEBUG: TOMBOL INI HARUS MUNCUL -->
                    <a href="/buatsurat" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors flex items-center">
                        <i class="fas fa-plus mr-2"></i> Buat Surat Baru
                    </a>
                </div>

                <!-- Search Section -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex flex-col md:flex-row gap-4 flex-wrap">
                        <div class="flex-1 min-w-[200px]">
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
                        <div class="md:w-48 min-w-[150px]">
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
                        <div class="md:w-48 min-w-[150px]">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="Draft">Draft</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dikirim">Dikirim</option>
                            </select>
                        </div>
                        <div class="md:w-48 min-w-[150px]">
                            <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                            <button onclick="refreshData()" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-sync-alt mr-2"></i>Refresh
                            </button>
                        </div>
                    </div>
                    <!-- Search Results Info -->
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

                <div class="overflow-x-auto w-full">
                    <table class="min-w-max w-full divide-y divide-gray-200 fixed-table">
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

                <!-- Pagination Info -->
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
            <form>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" value="Administrator" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" value="admin@pondok.com" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                        <input type="tel" value="081234567890" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                        <input type="text" value="Administrator Sistem" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3">Jl. Pondok Pesantren No. 123, Kecamatan Pondok, Kota Santri</textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeProfileModal()" class="px-4 py-2 border border-gray-300 rounded-md">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Authentication check
        document.addEventListener('DOMContentLoaded', function() {
            initializeLetterData();
            setupEventListeners();
        });

        function checkAuth() {
            const loginData = JSON.parse(localStorage.getItem('loginData') || sessionStorage.getItem('loginData') || 'null');

            if (!loginData || loginData.role !== 'admin') {
                alert('Anda harus login sebagai admin untuk mengakses halaman ini!');
                window.location.href = '/login';
                return;
            }

            // Update user info in header
            updateUserInfo(loginData);
        }

        function updateUserInfo(loginData) {
            const userSpan = document.querySelector('button[onclick="toggleProfileDropdown()"] span');
            if (userSpan) {
                userSpan.textContent = loginData.email.split('@')[0];
            }
        }

        let allLetterData = [];
        let filteredLetterData = [];
        let currentPage = 1;
        const itemsPerPage = 10;
        let currentLetterData = null;

        function initializeLetterData() {
            fetch('/api/surat')
                .then(response => response.json())
                .then(data => {
                    allLetterData = data;
                    filteredLetterData = [...data];
                    renderLetterTable();
                    updatePaginationInfo();
                    updateSearchResultsInfo();
                })
                .catch(error => {
                    console.error('Gagal mengambil data surat:', error);
                    allLetterData = [];
                    filteredLetterData = [];
                    renderLetterTable();
                    updatePaginationInfo();
                    updateSearchResultsInfo();
                });
        }

        function setupEventListeners() {
            const searchInput = document.getElementById('searchInput');
            const jenisSuratFilter = document.getElementById('jenisSuratFilter');
            const statusFilter = document.getElementById('statusFilter');

            // Search input with debounce for better performance
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    performSearch();
                    showSearchNotification();
                }, 300);
            });

            // Filter changes with immediate response
            jenisSuratFilter.addEventListener('change', function() {
                performSearch();
                showFilterNotification();
            });

            statusFilter.addEventListener('change', function() {
                performSearch();
                showFilterNotification();
            });

            // Enter key to search
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                    showSearchNotification();
                }
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + F to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    searchInput.focus();
                    searchInput.select();
                }

                // Escape to refresh data
                if (e.key === 'Escape') {
                    if (searchInput === document.activeElement) {
                        refreshData();
                    }
                }
            });

            // Focus search input on page load
            searchInput.focus();
        }

        function performSearch() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const jenisSuratFilter = document.getElementById('jenisSuratFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;

            filteredLetterData = allLetterData.filter(letter => {
                // Enhanced search term filter with multiple criteria
                const matchesSearch = !searchTerm ||
                    letter.nomorSurat.toLowerCase().includes(searchTerm) ||
                    getJenisSuratDisplayName(letter.jenisSurat).toLowerCase().includes(searchTerm) ||
                    (letter.nis && letter.nis.toLowerCase().includes(searchTerm)) ||
                    (letter.perihal && letter.perihal.toLowerCase().includes(searchTerm)) ||
                    (letter.namaSantri && letter.namaSantri.toLowerCase().includes(searchTerm));

                // Jenis surat filter
                const matchesJenisSurat = !jenisSuratFilter || letter.jenisSurat === jenisSuratFilter;

                // Status filter
                const matchesStatus = !statusFilter || letter.status === statusFilter;

                return matchesSearch && matchesJenisSurat && matchesStatus;
            });

            currentPage = 1;
            renderLetterTable();
            updatePaginationInfo();
            updateSearchResultsInfo();
        }

        function clearSearch() {
            document.getElementById('searchInput').value = '';
            document.getElementById('jenisSuratFilter').value = '';
            document.getElementById('statusFilter').value = '';
            filteredLetterData = [...allLetterData];
            currentPage = 1;
            renderLetterTable();
            updatePaginationInfo();
            updateSearchResultsInfo();
        }

        function refreshData() {
            // Clear all filters and search
            clearSearch();

            // Show refresh notification
            showNotification('Data berhasil diperbarui!', 'success');

            // Optional: Add a small loading effect
            const refreshButton = document.querySelector('button[onclick="refreshData()"]');
            const originalContent = refreshButton.innerHTML;

            refreshButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui...';
            refreshButton.disabled = true;

            setTimeout(() => {
                refreshButton.innerHTML = originalContent;
                refreshButton.disabled = false;
            }, 1000);
        }

        function showSearchNotification() {
            const searchTerm = document.getElementById('searchInput').value.trim();
            if (searchTerm) {
                const results = filteredLetterData.length;
                if (results > 0) {
                    showNotification(`Ditemukan ${results} surat untuk "${searchTerm}"`, 'info');
                } else {
                    showNotification(`Tidak ada surat ditemukan untuk "${searchTerm}"`, 'warning');
                }
            }
        }

        function showFilterNotification() {
            const jenisSuratFilter = document.getElementById('jenisSuratFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;

            let message = '';
            if (jenisSuratFilter && statusFilter) {
                message = `Filter: ${getJenisSuratDisplayName(jenisSuratFilter)} - ${statusFilter}`;
            } else if (jenisSuratFilter) {
                message = `Filter Jenis: ${getJenisSuratDisplayName(jenisSuratFilter)}`;
            } else if (statusFilter) {
                message = `Filter Status: ${statusFilter}`;
            }

            if (message) {
                const results = filteredLetterData.length;
                showNotification(`${message} (${results} hasil)`, 'info');
            }
        }

        function updateSearchResultsInfo() {
            const searchTerm = document.getElementById('searchInput').value.trim();
            const jenisSuratFilter = document.getElementById('jenisSuratFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;

            let infoText = `Menampilkan ${filteredLetterData.length} dari ${allLetterData.length} surat`;

            if (searchTerm || jenisSuratFilter || statusFilter) {
                infoText += ' (hasil pencarian)';
            }

            const infoElement = document.getElementById('searchResultsInfo');
            if (infoElement) {
                infoElement.textContent = infoText;
            }
        }

        function renderLetterTable() {
            const tableBody = document.getElementById('letterTableBody');
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const paginatedData = filteredLetterData.slice(startIndex, endIndex);

            if (paginatedData.length === 0) {
                const searchTerm = document.getElementById('searchInput').value.trim();
                const jenisSuratFilter = document.getElementById('jenisSuratFilter').value;
                const statusFilter = document.getElementById('statusFilter').value;

                let emptyMessage = '';
                let emptySubMessage = '';

                if (searchTerm || jenisSuratFilter || statusFilter) {
                    // No results from search/filter
                    emptyMessage = 'Tidak ada data surat ditemukan';
                    emptySubMessage = 'Coba ubah kata kunci pencarian atau filter yang digunakan';

                    if (searchTerm) {
                        emptyMessage = `Tidak ada surat ditemukan untuk "${searchTerm}"`;
                    }
                } else {
                    // No data at all
                    emptyMessage = 'Belum ada surat tersimpan';
                    emptySubMessage = 'Buat surat baru untuk mulai menyimpan draft';
                }

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-search text-6xl mb-4 text-gray-300"></i>
                                <h3 class="text-lg font-medium text-gray-700 mb-2">${emptyMessage}</h3>
                                <p class="text-sm text-gray-500 mb-4">${emptySubMessage}</p>
                                ${!searchTerm && !jenisSuratFilter && !statusFilter ? `
                                    <a href="/buatsurat" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-plus mr-2"></i>Buat Surat Pertama
                                    </a>
                                ` : `
                                    <button onclick="refreshData()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                                        <i class="fas fa-sync-alt mr-2"></i>Refresh Data
                                    </button>
                                `}
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = '';

            paginatedData.forEach((letter, index) => {
                const row = document.createElement('tr');
                const rowNumber = startIndex + index + 1;

                // Highlight search terms if present
                const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
                const highlightText = (text) => {
                    if (!searchTerm || !text) return text || 'N/A';
                    const regex = new RegExp(`(${searchTerm})`, 'gi');
                    return text.replace(regex, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>');
                };

                row.innerHTML = `
                    <td class="table-cell col-no">
                        <div class="table-cell-content">${rowNumber}</div>
                    </td>
                    <td class="table-cell col-nomor">
                        <div class="table-cell-content font-medium text-gray-900">${highlightText(letter.nomor_surat)}</div>
                    </td>
                    <td class="table-cell col-jenis">
                        <div class="table-cell-content">${highlightText(getJenisSuratDisplayName(letter.jenis_surat))}</div>
                    </td>
                    <td class="table-cell col-tanggal">
                        <div class="table-cell-content">${formatDate(letter.tanggal_surat)}</div>
                    </td>
                    <td class="table-cell col-nis">
                        <div class="table-cell-content">${highlightText(letter.santri.nis)}</div>
                    </td>
                    <td class="table-cell col-perihal">
                        <div class="table-cell-content">${highlightText(letter.alasan)}</div>
                    </td>
                    <td class="table-cell col-status">
                        <div class="table-cell-content">
                            <span class="px-3 py-1 ${getStatusColor(letter.status)} text-xs rounded-full">
                                ${letter.status}
                            </span>
                        </div>
                    </td>
                    <td class="table-cell col-aksi text-center">
                        <div class="table-cell-content actions">
                            <button onclick="viewLetter(${allLetterData.indexOf(letter)})" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="printLetterFromList(${allLetterData.indexOf(letter)})" class="text-green-600 hover:text-green-800" title="Cetak">
                                <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function getJenisSuratDisplayName(jenisSurat) {
            const displayNames = {
                'izin-pulang': 'Surat Izin Pulang',
                'sakit': 'Surat Sakit',
                'rekomendasi': 'Surat Rekomendasi',
                'keterangan': 'Surat Keterangan',
                'undangan': 'Surat Undangan'
            };
            return displayNames[jenisSurat] || jenisSurat;
        }

        function getStatusColor(status) {
            switch (status) {
                case 'Draft':
                    return 'bg-gray-100 text-gray-800';
                case 'Selesai':
                    return 'bg-green-100 text-green-800';
                case 'Dikirim':
                    return 'bg-blue-100 text-blue-800';
                default:
                    return 'bg-gray-100 text-gray-800';
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID');
        }

        function viewLetter(index) {
            try {
                const drafts = JSON.parse(localStorage.getItem('letterDrafts') || '[]');
                const letter = drafts[index];

                if (!letter) {
                    showNotification('Data surat tidak ditemukan!', 'error');
                    return;
                }

                currentLetterData = letter;

                const modalContent = document.getElementById('letterDetailContent');
                modalContent.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Informasi Surat</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nomor Surat:</label>
                                    <p class="text-gray-900">${letter.nomorSurat}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Surat:</label>
                                    <p class="text-gray-900">${getJenisSuratDisplayName(letter.jenisSurat)}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Template:</label>
                                    <p class="text-gray-900">${letter.templateSurat}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Surat:</label>
                                    <p class="text-gray-900">${formatDate(letter.tanggalSurat)}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status:</label>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">${letter.status}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Informasi Santri</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIS:</label>
                                    <p class="text-gray-900">${letter.nis || 'N/A'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Santri:</label>
                                    <p class="text-gray-900">${letter.namaSantri}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Alasan:</label>
                                    <p class="text-gray-900">${letter.alasan || 'N/A'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Diagnosa:</label>
                                    <p class="text-gray-900">${letter.diagnosa || 'N/A'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Kembali:</label>
                                    <p class="text-gray-900">${letter.tanggalKembali ? formatDate(letter.tanggalKembali) : 'N/A'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Isi Surat</h4>
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            ${letter.content}
                        </div>
                    </div>
                `;

                document.getElementById('letterDetailModal').classList.remove('hidden');

            } catch (error) {
                console.error('Error viewing letter:', error);
                showNotification('Gagal menampilkan detail surat!', 'error');
            }
        }

        function closeLetterDetailModal() {
            document.getElementById('letterDetailModal').classList.add('hidden');
            currentLetterData = null;
        }

        function printLetter() {
            if (!currentLetterData) {
                showNotification('Tidak ada surat yang dipilih!', 'error');
                return;
            }

            const printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Cetak Surat - ${currentLetterData.nomorSurat}</title>
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
                        ${currentLetterData.content}
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();

            setTimeout(() => {
                printWindow.print();
            }, 500);
        }

        function printLetterFromList(index) {
            try {
                const drafts = JSON.parse(localStorage.getItem('letterDrafts') || '[]');
                const letter = drafts[index];

                if (!letter) {
                    showNotification('Data surat tidak ditemukan!', 'error');
                    return;
                }

                const printWindow = window.open('', '_blank', 'width=800,height=600');
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Cetak Surat - ${letter.nomorSurat}</title>
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
                            ${letter.content}
                        </div>
                    </body>
                    </html>
                `);
                printWindow.document.close();

                setTimeout(() => {
                    printWindow.print();
                }, 500);

            } catch (error) {
                console.error('Error printing letter:', error);
                showNotification('Gagal mencetak surat!', 'error');
            }
        }

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

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const profileButton = event.target.closest('button[onclick="toggleProfileDropdown()"]');

            if (!profileButton && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        function logout() {
            showLogoutConfirmation();
        }

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

        document.addEventListener('click', function(event) {
            const modalOverlay = document.getElementById('logoutModalOverlay');
            if (modalOverlay && event.target === modalOverlay) {
                cancelLogout();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modalOverlay = document.getElementById('logoutModalOverlay');
                if (modalOverlay) {
                    cancelLogout();
                }
            }
        });

        function openProfileModal() {
            document.getElementById('profileModal').classList.remove('hidden');
            document.getElementById('profileDropdown').classList.add('hidden');
        }

        function closeProfileModal() {
            document.getElementById('profileModal').classList.add('hidden');
        }

        function openSettingsModal() {
            alert('Fitur pengaturan akan segera hadir!');
            document.getElementById('profileDropdown').classList.add('hidden');
        }

        window.onclick = function(event) {
            const modals = ['profileModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        }

        function updatePaginationInfo() {
            const totalItems = filteredLetterData.length;
            const startIndex = totalItems === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
            const endIndex = Math.min(currentPage * itemsPerPage, totalItems);

            document.getElementById('startIndex').textContent = startIndex;
            document.getElementById('endIndex').textContent = endIndex;
            document.getElementById('totalItems').textContent = totalItems;

            // Update pagination buttons
            const prevButton = document.getElementById('prevPage');
            const nextButton = document.getElementById('nextPage');

            prevButton.disabled = currentPage === 1;
            nextButton.disabled = endIndex >= totalItems;

            prevButton.classList.toggle('opacity-50', currentPage === 1);
            nextButton.classList.toggle('opacity-50', endIndex >= totalItems);
        }

        function previousPage() {
            if (currentPage > 1) {
                currentPage--;
                renderLetterTable();
                updatePaginationInfo();
            }
        }

        function nextPage() {
            const totalPages = Math.ceil(filteredLetterData.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderLetterTable();
                updatePaginationInfo();
            }
        }

        function highlightLetterFromQuery() {
            const params = new URLSearchParams(window.location.search);
            const highlightNomor = params.get('highlight');
            if (!highlightNomor) return;
            setTimeout(() => {
                const rows = document.querySelectorAll('#letterTableBody tr');
                for (const row of rows) {
                    if (row.innerHTML.includes(highlightNomor)) {
                        row.classList.add('bg-yellow-100', 'transition');
                        row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        setTimeout(() => {
                            row.classList.remove('bg-yellow-100');
                        }, 2500);
                        break;
                    }
                }
            }, 500); // Delay to ensure table is rendered
        }
    </script>
</body>
</html>
