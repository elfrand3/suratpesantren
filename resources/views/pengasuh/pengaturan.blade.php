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
    <div class="ml-72 pt-16">
        @include('components.navbar', ['title' => 'Pengaturan'])
        <main class="flex-1 w-full flex flex-col items-center justify-start p-8">
            <!-- Profil User -->
            <div class="w-full max-w-lg bg-white rounded-xl shadow p-6 mb-4 flex items-center space-x-4">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=64&h=64&q=80" class="w-16 h-16 rounded-full border-2 border-blue-500" alt="User">
                <div>
                    <div class="font-bold text-lg text-gray-800">Pengasuh Surat</div>
                    <div class="text-sm text-gray-500">@pengasuh</div>
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
                </button> --}}
            </div>
            <!-- Tab Content -->
            <div id="content-profile" class="w-full max-w-lg bg-white rounded-xl shadow p-8 mb-8">
                {{-- <h2 class="text-xl font-bold mb-6 flex items-center"><i class="fas fa-user mr-2 text-blue-500"></i> Pengaturan Profil</h2> --}}
                <form class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="Pengasuh Surat">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="pengasuh@email.com">
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
    <script>
        function showTab(tab) {
            document.getElementById('content-profile').classList.add('hidden');
            document.getElementById('content-password').classList.add('hidden');
            document.getElementById('content-notif').classList.add('hidden');
            document.getElementById('tab-profile').classList.remove('bg-blue-100', 'text-blue-700');
            // document.getElementById('tab-password').classList.remove('bg-blue-100', 'text-blue-700');
            // document.getElementById('tab-notif').classList.remove('bg-blue-100', 'text-blue-700');
            if(tab === 'profile') {
                document.getElementById('content-profile').classList.remove('hidden');
                document.getElementById('tab-profile').classList.add('bg-blue-100', 'text-blue-700');
            } else if(tab === 'password') {
                document.getElementById('content-password').classList.remove('hidden');
                document.getElementById('tab-password').classList.add('hidden');
                // document.getElementById('tab-password').classList.add('bg-blue-100', 'text-blue-700');
            } else if(tab === 'notif') {
                document.getElementById('content-notif').classList.remove('hidden');
                document.getElementById('tab-notif').classList.add('hidden  ');
                // document.getElementById('tab-notif').classList.add('bg-blue-100', 'text-blue-700');
            }
        }
        // Default tab
        showTab('profile');
    </script>
</body>
</html>
