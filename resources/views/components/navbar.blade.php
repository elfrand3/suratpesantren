<!-- Top Navigation -->
<header class="fixed top-0 left-72 right-0 w-[calc(100%-18rem)] bg-white shadow-sm border-b border-gray-200 z-50">
    <div class="flex items-center justify-between h-16 px-6">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h2>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-3">
                {{-- <img src="{{ $userImage ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80' }}"
                     alt="User" class="h-8 w-8 rounded-full"> --}}
                <div class="relative">
                    <button onclick="toggleProfileDropdown()" class="flex items-center space-x-2 text-gray-700 font-medium hover:text-blue-600 transition-colors">
                        <span>{{ old('name', Auth::user()->name) }}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <!-- Profile Dropdown -->
                    <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                        {{-- <a href="#" onclick="showProfileModal(); return false;" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <i class="fas fa-user mr-3"></i>
                            <span>Profil Saya</span>
                        </a> --}}
                        <div class="border-t border-gray-100"></div>
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="button" onclick="document.getElementById('logoutForm').submit();" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                <i class="fas fa-sign-out-alt mr-3"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
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
                                    <a href="/adminpengaturan" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-cog mr-2"></i>Pengaturan
                                    </a>
                                    <button onclick="closeProfileModal()" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Notification Container (for elegant stacked notifications) -->
<div id="notificationContainer" class="fixed top-20 right-8 z-[9999] flex flex-col items-end space-y-3 w-full max-w-xs sm:max-w-sm pointer-events-none"></div>

<!-- Modal Konfirmasi Logout -->
<div id="logoutConfirmModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[9999] hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md text-center">
        <div class="mb-4">
            <i class="fas fa-sign-out-alt text-3xl text-red-600 mb-2"></i>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Logout</h3>
            <p class="text-gray-600">Apakah Anda yakin ingin keluar dari sistem?</p>
        </div>
        <div class="flex justify-center gap-4 mt-6">
            <button onclick="hideLogoutConfirmModal()" class="px-6 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">Tidak</button>
            <button onclick="submitLogoutForm()" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">Iya</button>
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
        if (!profileButton && dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
    // openProfileModal bisa diarahkan ke halaman pengaturan atau modal sederhana jika diinginkan
    function openProfileModal() {
        window.location.href = '/pengaturan';
    }

    // Show Notification Function (available on all admin pages)
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

    function showProfileModal() {
        document.getElementById('profileModal').classList.remove('hidden');
        document.getElementById('profileDropdown').classList.add('hidden');
    }
    function closeProfileModal() {
        document.getElementById('profileModal').classList.add('hidden');
    }
    function goToSettings() {
        window.location.href = '/pengaturan';
    }

    function showLogoutConfirmModal() {
        document.getElementById('logoutConfirmModal').classList.remove('hidden');
        document.getElementById('profileDropdown').classList.add('hidden');
    }
    function hideLogoutConfirmModal() {
        document.getElementById('logoutConfirmModal').classList.add('hidden');
    }
    function submitLogoutForm() {
        document.getElementById('logoutForm').submit();
    }
</script>
