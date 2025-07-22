<!DOCTYPE html>
<html lang="en" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>Pengaturan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="ml-72 pt-16">
        @include('components.navbar', ['title' => 'Pengaturan'])

        <!-- Settings Content -->
        <main class="flex-1 w-full flex flex-col items-center justify-start p-8">
            <!-- Profil User -->
            <div class="w-full max-w-lg bg-white rounded-xl shadow p-6 mb-4 flex items-center space-x-4">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=64&h=64&q=80" class="w-16 h-16 rounded-full border-2 border-blue-500" alt="User">
                <div>
                    <div class="font-bold text-lg text-gray-800">Admin Surat</div>
                    <div class="text-sm text-gray-500">@admin</div>
                </div>
            </div>
            <!-- Menu Pengaturan (Tab) -->
            <div class="w-full max-w-lg flex flex-wrap items-center gap-2 mb-6">
                <button onclick="showTab('profile')" id="tab-profile" class="flex-1 min-w-[110px] flex items-center justify-center px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 focus:bg-blue-100 font-medium transition text-sm">
                    <i class="fas fa-user mr-2"></i> Profil
                </button>
                {{-- <button onclick="showTab('password')" id="tab-password" class="flex-1 min-w-[110px] flex items-center justify-center px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 focus:bg-blue-100 font-medium transition text-sm">
                    <i class="fas fa-lock mr-2"></i> Password
                </button>
                <button onclick="showTab('notif')" id="tab-notif" class="flex-1 min-w-[110px] flex items-center justify-center px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 focus:bg-blue-100 font-medium transition text-sm">
                    <i class="fas fa-bell mr-2"></i> Notifikasi
                </button>
                <!-- Tombol Lainnya jika menu lebih dari 3 -->
                <button id="tab-lainnya" onclick="toggleLainnya()" class="hidden flex-1 min-w-[110px] items-center justify-center px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 focus:bg-blue-100 font-medium transition text-sm">
                    <i class="fas fa-ellipsis-h mr-2"></i> Lainnya
                </button> --}}
            </div>
            <!-- Menu tambahan jika ada (hidden by default) -->
            <div id="lainnya-menu" class="w-full max-w-lg flex flex-wrap items-center gap-2 mb-6 hidden">
                <!-- Contoh menu tambahan -->
                <button class="flex-1 min-w-[110px] flex items-center justify-center px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 focus:bg-blue-100 font-medium transition text-sm">
                    <i class="fas fa-shield-alt mr-2"></i> Privasi
                </button>
                <button class="flex-1 min-w-[110px] flex items-center justify-center px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 focus:bg-blue-100 font-medium transition text-sm">
                    <i class="fas fa-language mr-2"></i> Bahasa
                </button>
            </div>
            <!-- Tab Content -->
            <div id="content-profile" class="w-full max-w-lg bg-white rounded-xl shadow p-8 mb-8">
                {{-- <h2 class="text-xl font-bold mb-6 flex items-center"><i class="fas fa-user mr-2 text-blue-500"></i> Pengaturan Profil</h2> --}}
                <form class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name', Auth::user()->name) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('email', Auth::user()->email) }}">
                    </div>
                    {{-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                        <input type="file" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="form-submit-btn px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Simpan</button>
                    </div> --}}
                </form>
            </div>
            <div id="content-password" class="w-full max-w-lg bg-white rounded-xl shadow p-8 mb-8 hidden">
                <h2 class="text-xl font-bold mb-6 flex items-center"><i class="fas fa-lock mr-2 text-blue-500"></i> Ganti Password</h2>
                <form class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                        <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="form-submit-btn px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Simpan</button>
                    </div>
                </form>
            </div>
            <div id="content-notif" class="w-full max-w-lg bg-white rounded-xl shadow p-8 mb-8 hidden">
                <h2 class="text-xl font-bold mb-6 flex items-center"><i class="fas fa-bell mr-2 text-blue-500"></i> Pengaturan Notifikasi</h2>
                <form class="space-y-5">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Email Notifikasi</span>
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" checked>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Push Notifikasi</span>
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Newsletter</span>
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="form-submit-btn px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Simpan</button>
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
            modalOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]';

            // Create modal content
            const modalContent = document.createElement('div');
            modalContent.className = 'bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0';
            modalContent.innerHTML = `
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                        <i class="fas fa-sign-out-alt text-2xl text-red-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Konfirmasi Keluar</h3>
                    <p class="text-gray-600 mb-8">Apakah Anda yakin ingin keluar dari sistem? Semua data yang belum disimpan akan hilang.</p>
                    <div class="flex space-x-4">
                        <button onclick="cancelLogout()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            Batal
                        </button>
                        <button onclick="confirmLogout()" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                        </button>
                    </div>
                </div>
            `;

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
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-6">
                        <i class="fas fa-spinner fa-spin text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Memproses...</h3>
                    <p class="text-gray-600">Sedang keluar dari sistem...</p>
                </div>
            `;

            // Show notification
            showNotification('Sedang keluar dari sistem...', 'info');

            setTimeout(() => {
                // Clear login data
                localStorage.removeItem('loginData');
                sessionStorage.removeItem('loginData');

                // Show success notification
                showNotification('Berhasil keluar dari sistem!', 'success');

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

        function showTab(tab) {
            document.getElementById('content-profile').classList.add('hidden');
            document.getElementById('content-password').classList.add('hidden');
            document.getElementById('content-notif').classList.add('hidden');
            document.getElementById('tab-profile').classList.remove('bg-blue-100');
            // document.getElementById('tab-password').classList.remove('bg-blue-100');
            // document.getElementById('tab-notif').classList.remove('bg-blue-100');
            if(tab === 'profile') {
                document.getElementById('content-profile').classList.remove('hidden');
                document.getElementById('tab-profile').classList.add('bg-blue-100');
            } else if(tab === 'password') {
                document.getElementById('content-password').classList.remove('hidden');
                document.getElementById('tab-password').classList.add('bg-blue-100');
            } else if(tab === 'notif') {
                document.getElementById('content-notif').classList.remove('hidden');
                document.getElementById('tab-notif').classList.add('bg-blue-100');
            }
        }
        // Default tab
        showTab('profile');
        // Toggle menu lainnya
        function toggleLainnya() {
            var menu = document.getElementById('lainnya-menu');
            menu.classList.toggle('hidden');
        }
        // Show Notification Function
        function showNotification(message, type = 'info') {
            // Remove existing notification container if any
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
            notification.className = `notification px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full opacity-0 ${
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

        // Handle form submissions
        document.addEventListener('DOMContentLoaded', function() {
            // Profile form submission
            const profileForm = document.querySelector('#content-profile form');
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Add loading effect to submit button
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                    submitBtn.disabled = true;

                    showNotification('Menyimpan pengaturan profil...', 'info');
                    setTimeout(() => {
                        showNotification('Pengaturan profil berhasil disimpan!', 'success');
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 600);
                });
            }

            // Password form submission
            const passwordForm = document.querySelector('#content-password form');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Add loading effect to submit button
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengubah...';
                    submitBtn.disabled = true;

                    showNotification('Mengubah password...', 'info');
                    setTimeout(() => {
                        showNotification('Password berhasil diubah!', 'success');
                        passwordForm.reset();
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 600);
                });
            }

            // Notification form submission
            const notifForm = document.querySelector('#content-notif form');
            if (notifForm) {
                notifForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Add loading effect to submit button
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                    submitBtn.disabled = true;

                    showNotification('Menyimpan pengaturan notifikasi...', 'info');
                    setTimeout(() => {
                        showNotification('Pengaturan notifikasi berhasil disimpan!', 'success');
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 600);
                });
            }
        });

        // Go to settings function
        function goToSettings() {
            showNotification('Mengarahkan ke pengaturan...', 'info');
            setTimeout(() => {
                // Already in settings page, just close modal
                closeProfileModal();
            }, 500);
        }
    </script>
</body>
</html>
