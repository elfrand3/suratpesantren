<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengasuh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('components.sidebar')
    <div class="ml-72 pt-16">
        @include('components.navbar', ['title' => 'Dashboard Pengasuh', 'userName' => 'Pengasuh', 'notificationCount' => 3])
        <main class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-envelope text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Surat</p>
                            <p class="text-2xl font-bold text-gray-900" id="">{{ $totalSurat ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Surat Disetujui</p>
                            <p class="text-2xl font-bold text-gray-900" id="">{{ $suratDisetujui ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Menunggu</p>
                            <p class="text-2xl font-bold text-gray-900" id="">{{ $suratMenunggu ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Santri Aktif</p>
                            <p class="text-2xl font-bold text-gray-900" id="">{{ $santri ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center justify-center min-h-[400px]">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Selamat Datang di Dashboard Pengasuh</h1>
                <p class="text-gray-600 mb-2">Silakan setujui data surat santri melalui menu di sidebar.</p>
                <div class="mt-6">
                    <i class="fas fa-user-tie text-5xl text-blue-400"></i>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
