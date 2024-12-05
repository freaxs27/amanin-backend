{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filament App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Jika Anda menggunakan Vite --}}
</head>
<body class="bg-gray-100">
    @yield('content') {{-- Konten halaman utama akan ditempatkan di sini --}}
</body>
</html>
