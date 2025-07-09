<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Administrasi Surat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="ml-72 pt-16">
        @include('components.navbar', ['title' => 'Dashboard'])

        <!-- Dashboard Content -->
        <main class="p-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-envelope text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Surat</p>
                            <p class="text-2xl font-bold text-gray-900" id="totalSurat">0</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>8%
                        </span>
                        <span class="text-gray-500 text-sm">bulan ini</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Surat Disetujui</p>
                            <p class="text-2xl font-bold text-gray-900" id="suratDisetujui">0</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>12%
                        </span>
                        <span class="text-gray-500 text-sm">bulan ini</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Menunggu</p>
                            <p class="text-2xl font-bold text-gray-900" id="suratMenunggu">0</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-red-600 text-sm font-medium">
                            <i class="fas fa-arrow-down mr-1"></i>5%
                        </span>
                        <span class="text-gray-500 text-sm">bulan ini</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Santri Aktif</p>
                            <p class="text-2xl font-bold text-gray-900" id="santriAktif">0</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>3%
                        </span>
                        <span class="text-gray-500 text-sm">bulan ini</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Letters -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <button onclick="quickAction('buat-surat')" class="quick-action-btn w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-medium">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Surat Baru
                        </button>
                        <button onclick="quickAction('export-laporan')" class="quick-action-btn w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors font-medium">
                            <i class="fas fa-file-export mr-2"></i>
                            Export Laporan
                        </button>
                        <button onclick="quickAction('tambah-santri')" class="quick-action-btn w-full flex items-center justify-center px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors font-medium">
                            <i class="fas fa-user-plus mr-2"></i>
                            Tambah Santri
                        </button>
                        <button onclick="quickAction('pengaturan')" class="quick-action-btn w-full flex items-center justify-center px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors font-medium">
                            <i class="fas fa-cog mr-2"></i>
                            Pengaturan
                        </button>
                    </div>
                </div>

                <!-- Recent Letters -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Surat Terbaru</h3>
                        <a href="/dps" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua</a>
                    </div>
                    <div id="recentLetters" class="space-y-4"></div>
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
            
            renderRecentLetters();
            updateDashboardStats();
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
            alert('Fitur pengaturan akan segera hadir!');
            document.getElementById('profileDropdown').classList.add('hidden');
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

        // Quick Actions Function
        function quickAction(action) {
            // Add loading effect to button
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            button.disabled = true;
            
            switch(action) {
                case 'buat-surat':
                    showNotification('Mengarahkan ke halaman Buat Surat...', 'info');
                    setTimeout(() => {
                        window.location.href = '/bs';
                    }, 300);
                    break;
                    
                case 'export-laporan':
                    showNotification('Menyiapkan laporan untuk di-export...', 'info');
                    setTimeout(() => {
                        exportLaporan();
                        // Reset button after export
                        setTimeout(() => {
                            button.innerHTML = originalText;
                            button.disabled = false;
                        }, 1000);
                    }, 300);
                    break;
                    
                case 'tambah-santri':
                    showNotification('Mengarahkan ke halaman Data Santri...', 'info');
                    setTimeout(() => {
                        window.location.href = '/ds';
                    }, 300);
                    break;
                    
                case 'pengaturan':
                    showNotification('Mengarahkan ke halaman Pengaturan...', 'info');
                    setTimeout(() => {
                        window.location.href = '/p';
                    }, 300);
                    break;
                    
                default:
                    showNotification('Aksi tidak dikenali!', 'error');
                    button.innerHTML = originalText;
                    button.disabled = false;
            }
        }

        // Export Laporan Function
        function exportLaporan() {
            // Simulate export process
            showNotification('Mengunduh laporan...', 'info');
            
            setTimeout(() => {
                // Create a dummy CSV file for download
                const csvContent = "data:text/csv;charset=utf-8," 
                    + "No,Nama,Jenis Surat,Tanggal,Status\n"
                    + "1,John Doe,Surat Tugas,2024-01-15,Disetujui\n"
                    + "2,Jane Smith,Surat Izin,2024-01-14,Menunggu\n"
                    + "3,Mike Johnson,Surat Rekomendasi,2024-01-13,Disetujui\n"
                    + "4,Sarah Wilson,Surat Tugas,2024-01-12,Disetujui\n"
                    + "5,David Brown,Surat Izin,2024-01-11,Menunggu";
                
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "laporan_surat_" + new Date().toISOString().split('T')[0] + ".csv");
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                showNotification('Laporan berhasil di-export!', 'success');
            }, 500);
        }

        // Show Notification Function
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

        // Fungsi untuk format waktu relatif
        function timeAgo(dateString) {
            const now = new Date();
            const date = new Date(dateString);
            const diff = Math.floor((now - date) / 1000); // in seconds
            if (diff < 60) return `${diff} detik yang lalu`;
            if (diff < 3600) return `${Math.floor(diff/60)} menit yang lalu`;
            if (diff < 86400) return `${Math.floor(diff/3600)} jam yang lalu`;
            return `${Math.floor(diff/86400)} hari yang lalu`;
        }

        // Render Surat Terbaru dari localStorage
        function renderRecentLetters() {
            const container = document.getElementById('recentLetters');
            if (!container) return;
            let drafts = [];
            try {
                drafts = JSON.parse(localStorage.getItem('letterDrafts') || '[]');
            } catch (e) {}
            drafts.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
            const recent = drafts.slice(0, 3);
            if (recent.length === 0) {
                container.innerHTML = '<div class="text-gray-500 text-center py-8">Belum ada surat terbaru</div>';
                return;
            }
            container.innerHTML = recent.map(letter => `
                <a href="/dps?highlight=${encodeURIComponent(letter.nomorSurat)}" class="block">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-blue-50 transition">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">${letter.perihal || letter.jenisSurat}</p>
                                <p class="text-sm text-gray-500">Dari: ${letter.namaSantri || '-'} • ${timeAgo(letter.createdAt)}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 ${getStatusColor(letter.status)} text-xs rounded-full">${letter.status}</span>
                    </div>
                </a>
            `).join('');
        }

        function updateDashboardStats() {
            // Ambil semua surat
            let drafts = [];
            try {
                drafts = JSON.parse(localStorage.getItem('letterDrafts') || '[]');
            } catch (e) {}
            // Total surat
            const totalSurat = drafts.length;
            // Surat Disetujui
            const suratDisetujui = drafts.filter(s => s.status && s.status.toLowerCase().includes('setuju')).length;
            // Surat Menunggu
            const suratMenunggu = drafts.filter(s => s.status && s.status.toLowerCase().includes('menunggu')).length;
            // Santri Aktif (contoh, jika ada data santri di localStorage)
            let santri = [];
            try {
                santri = JSON.parse(localStorage.getItem('santriData') || '[]');
            } catch (e) {}
            const santriAktif = santri.filter(s => s.status && s.status.toLowerCase() === 'aktif').length;
            // Update ke HTML
            document.getElementById('totalSurat').textContent = totalSurat;
            document.getElementById('suratDisetujui').textContent = suratDisetujui;
            document.getElementById('suratMenunggu').textContent = suratMenunggu;
            document.getElementById('santriAktif').textContent = santriAktif;
        }
    </script>
</body>
</html>
