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
            <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center justify-center min-h-[400px]">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Selamat Datang di Dashboard Pengasuh</h1>
                <p class="text-gray-600 mb-2">Silakan kelola data santri, absensi, dan surat melalui menu di sidebar.</p>
                <div class="mt-6">
                    <i class="fas fa-user-tie text-5xl text-blue-400"></i>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 