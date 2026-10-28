<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NgawiLibrary</title>
    @vite('resources/css/app.css')
</head>
<body class="flex min-h-screen flex-col items-center justify-center gap-4 bg-gray-100">
    <h1 class="text-xl font-semibold">Dashboard</h1>
    <p class="text-sm text-gray-600">Masuk sebagai {{ auth()->user()->email }}</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="rounded bg-black px-4 py-2 text-white">Keluar</button>
    </form>
</body>
</html>
