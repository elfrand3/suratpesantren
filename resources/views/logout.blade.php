<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Sistem Surat Pondok Pesantren</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logout Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <!-- Header -->
            <div class="mb-8">
                <div class="logout-icon mx-auto w-20 h-20 mb-4 bg-red-600 rounded-full flex items-center justify-center" id="logoutIcon">
                    <i class="fas fa-sign-out-alt text-white text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Logout Berhasil</h1>
                <p class="text-gray-600">Anda telah keluar dari sistem</p>
            </div>

            <!-- Info -->
            <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-4" id="logoutMessage">
                    Terima kasih telah menggunakan Sistem Surat Pondok Pesantren
                </p>
                <div class="text-xs text-gray-500">
                    <p>Waktu logout: <span id="logoutTime"></span></p>
                    <p id="roleInfo" class="role-info mt-1"></p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="space-y-3">
                <button 
                    onclick="loginAgain()"
                    class="logout-btn w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-medium"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login Kembali
                </button>
                
                <button 
                    onclick="clearAllData()"
                    class="logout-btn w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors text-sm"
                >
                    <i class="fas fa-trash mr-2"></i>
                    Hapus Semua Data
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
                © 2024 Sistem Surat Pondok Pesantren. Semua hak dilindungi.
            </p>
        </div>
    </div>

    <script>
        // Set logout time
        document.getElementById('logoutTime').textContent = new Date().toLocaleString('id-ID');
        
        // Get user role from URL parameter or localStorage before clearing
        let userRole = 'admin'; // default
        const urlParams = new URLSearchParams(window.location.search);
        const roleParam = urlParams.get('role');
        
        if (roleParam) {
            userRole = roleParam;
        } else {
            // Try to get from localStorage before clearing
            try {
                const loginData = JSON.parse(localStorage.getItem('loginData') || sessionStorage.getItem('loginData') || 'null');
                if (loginData && loginData.role) {
                    userRole = loginData.role;
                }
            } catch (e) {
                console.log('Could not get role from storage');
            }
        }
        
        // Hide "Hapus Semua Data" button for pengasuh
        if (userRole === 'pengasuh') {
            const clearDataButton = document.querySelector('button[onclick="clearAllData()"]');
            if (clearDataButton) {
                clearDataButton.style.display = 'none';
            }
            
            // Update icon and color for pengasuh
            const logoutIcon = document.getElementById('logoutIcon');
            if (logoutIcon) {
                logoutIcon.className = 'logout-icon mx-auto w-20 h-20 mb-4 bg-green-600 rounded-full flex items-center justify-center';
                logoutIcon.innerHTML = '<i class="fas fa-user-tie text-white text-3xl"></i>';
            }
            
            // Update message for pengasuh
            const logoutMessage = document.getElementById('logoutMessage');
            const roleInfo = document.getElementById('roleInfo');
            
            if (logoutMessage) {
                logoutMessage.textContent = 'Terima kasih telah menggunakan Sistem Surat Pondok Pesantren sebagai Pengasuh';
            }
            
            if (roleInfo) {
                roleInfo.textContent = 'Role: Pengasuh';
                roleInfo.className = 'role-info mt-1 text-green-600 font-medium';
            }
        } else {
            // Update icon and color for admin
            const logoutIcon = document.getElementById('logoutIcon');
            if (logoutIcon) {
                logoutIcon.className = 'logout-icon mx-auto w-20 h-20 mb-4 bg-blue-600 rounded-full flex items-center justify-center';
                logoutIcon.innerHTML = '<i class="fas fa-user-shield text-white text-3xl"></i>';
            }
            
            // Update message for admin
            const logoutMessage = document.getElementById('logoutMessage');
            const roleInfo = document.getElementById('roleInfo');
            
            if (logoutMessage) {
                logoutMessage.textContent = 'Terima kasih telah menggunakan Sistem Surat Pondok Pesantren sebagai Administrator';
            }
            
            if (roleInfo) {
                roleInfo.textContent = 'Role: Administrator';
                roleInfo.className = 'role-info mt-1 text-blue-600 font-medium';
            }
        }
        
        // Clear login data
        localStorage.removeItem('loginData');
        sessionStorage.removeItem('loginData');
        
        // Login again function
        function loginAgain() {
            window.location.href = '/login';
        }
        
        // Clear all data function (only for admin)
        function clearAllData() {
            if (userRole === 'pengasuh') {
                return; // Prevent pengasuh from clearing data
            }
            
            if (confirm('Apakah Anda yakin ingin menghapus semua data? Ini akan menghapus semua data surat dan santri yang tersimpan.')) {
                // Clear all localStorage data
                localStorage.clear();
                sessionStorage.clear();
                
                alert('Semua data berhasil dihapus!');
                window.location.href = '/login';
            }
        }
        
        // Auto redirect after 10 seconds
        setTimeout(() => {
            window.location.href = '/login';
        }, 10000);
    </script>
</body>
</html> 