

<!-- Sidebar Admin -->
@if (Auth::check() && Auth::user()->role === 'Admin')
<div class=" md:block hidden fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-blue-700 via-blue-600 to-blue-800 shadow-2xl">
    <!-- Header -->
    <div class="flex items-center justify-between h-20 px-6 border-b border-blue-500/30 bg-blue-800/50 backdrop-blur-sm">
        <div class="flex items-center">
            <div class="flex items-center justify-center w-10 h-10 bg-white/20 rounded-xl mr-4 backdrop-blur-sm">
                <i class="fas fa-envelope text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-white">Admin Surat</h1>
                <p class="text-xs text-blue-200">Management System</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-8 px-4">
        <div class="space-y-2">
            <!-- Dashboard -->
            <a href="/admin" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('admin') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('admin') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-tachometer-alt text-sm"></i>
                </div>
                <span class="font-medium">Dasbor</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>

            <!-- Buat Surat -->
            <a href="/adminbuatsurat" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('adminbuatsurat') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('adminbuatsurat') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-plus-circle text-sm"></i>
                </div>
                <span class="font-medium">Buat Surat</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>

            <!-- Daftar Surat -->
            <a href="/admindaftarpembuatsurat" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('admindaftarpembuatsurat') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('admindaftarpembuatsurat') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-list text-sm"></i>
                </div>
                <span class="font-medium">Daftar Surat</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>

            <!-- Data Santri -->
            <a href="/admindatasantri" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('admindatasantri') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('admindatasantri') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <span class="font-medium">Data Santri</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>

            <!-- Template Surat -->
            <a href="/admintemplatesurat" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('admintemplatesurat') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('admintemplatesurat') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-file-alt text-sm"></i>
                </div>
                <span class="font-medium">Template Surat</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>

            <!-- Pengaturan -->
            <a href="/adminpengaturan" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('adminpengaturan') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('adminpengaturan') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-cog text-sm"></i>
                </div>
                <span class="font-medium">Pengaturan</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>
        </div>
    </nav>

    <!-- Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-500/30">
        <div class="flex items-center justify-center">
            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-shield-alt text-blue-200 text-sm"></i>
            </div>
            <div>
                <p class="text-xs text-blue-200 font-medium">Admin Panel</p>
                <p class="text-xs text-blue-300">Secure & Reliable</p>
            </div>
        </div>
    </div>
</div> 
@endif

<!-- Sidebar pengasuh -->
@if (Auth::check() && Auth::user()->role === 'Pengasuh')
<div class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-blue-700 via-blue-600 to-blue-800 shadow-2xl">
    <!-- Header -->
    <div class="flex items-center justify-between h-20 px-6 border-b border-blue-500/30 bg-blue-800/50 backdrop-blur-sm">
        <div class="flex items-center">
            <div class="flex items-center justify-center w-10 h-10 bg-white/20 rounded-xl mr-4 backdrop-blur-sm">
                <i class="fas fa-envelope text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-white">Pengasuh Surat</h1>
                <p class="text-xs text-blue-200">Management System</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-8 px-4">
        <div class="space-y-2">
            <!-- Dashboard -->
            <a href="/pengasuh" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('dp') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('dp') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-tachometer-alt text-sm"></i>
                </div>
                <span class="font-medium">Dasbor</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>

            <!-- Daftar Surat -->
            <a href="/pengasuhdaftarsantri" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('dps') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('dps') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-list text-sm"></i>
                </div>
                <span class="font-medium">Daftar Surat</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>

            <!-- Data Santri -->
            <a href="/pengasuhdatasantri" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('ds') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('ds') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <span class="font-medium">Data Santri</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>

            <!-- Pengaturan -->
            <a href="/pengasuhpengaturan" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('p') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('p') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-cog text-sm"></i>
                </div>
                <span class="font-medium">Pengaturan</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>
        </div>
        <div class="mt-6 p-4 bg-yellow-100 border-l-4 border-yellow-400 text-yellow-800 rounded">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <span>Peringatan: Pengasuh tidak dapat membuat surat dan menambah santri.</span>
        </div>
    </nav>

    <!-- Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-500/30">
        <div class="flex items-center justify-center">
            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-shield-alt text-blue-200 text-sm"></i>
            </div>
            <div>
                <p class="text-xs text-blue-200 font-medium">Admin Panel</p>
                <p class="text-xs text-blue-300">Secure & Reliable</p>
            </div>
        </div>
    </div>
</div> 
@endif

<!-- Sidebar sekolah -->
@if (Auth::check() && Auth::user()->role === 'Sekolah')
<div class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-blue-700 via-blue-600 to-blue-800 shadow-2xl">
    <!-- Header -->
    <div class="flex items-center justify-between h-20 px-6 border-b border-blue-500/30 bg-blue-800/50 backdrop-blur-sm">
        <div class="flex items-center">
            <div class="flex items-center justify-center w-10 h-10 bg-white/20 rounded-xl mr-4 backdrop-blur-sm">
                <i class="fas fa-envelope text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-white">Sekolah</h1>
                <p class="text-xs text-blue-200">Management System</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-8 px-4">
        <div class="space-y-2">
            <!-- Dashboard -->
            <a href="/sekolah" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('sekolah') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('sekolah') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-tachometer-alt text-sm"></i>
                </div>
                <span class="font-medium">Dasbor</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>
            <!-- Data Surat -->
            <a href="/sekolahdatasurat" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('sekolahdatasurat') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('sekolahdatasurat') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-envelope-open-text text-sm"></i>
                </div>
                <span class="font-medium">Data Surat</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>
            <!-- Data Santri -->
            <a href="/sekolahdatasantri" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('sekolahdatasantri') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('sekolahdatasantri') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <span class="font-medium">Data Santri</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>
            <!-- Pengaturan -->
            <a href="/sekolahpengaturan" class="group flex items-center px-4 py-4 text-blue-100 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300 {{ request()->is('sekolahpengaturan') ? 'text-white bg-white/15 shadow-lg' : '' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-4 rounded-lg {{ request()->is('sekolahpengaturan') ? 'bg-white/20' : 'bg-blue-500/30 group-hover:bg-white/20' }} transition-all duration-300">
                    <i class="fas fa-cog text-sm"></i>
                </div>
                <span class="font-medium">Pengaturan</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>
        </div>
    </nav>

    <!-- Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-500/30">
        <div class="flex items-center justify-center">
            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-shield-alt text-blue-200 text-sm"></i>
            </div>
            <div>
                <p class="text-xs text-blue-200 font-medium">Panel</p>
                <p class="text-xs text-blue-300">Secure & Reliable</p>
            </div>
        </div>
    </div>
</div> 
@endif