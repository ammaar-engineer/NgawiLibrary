<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NgawiLibrary</title>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/dashboard.jsx'])
</head>
<body>
    <div id="app"
        data-menu="{{ $menu }}"
        data-email="{{ auth()->user()->email }}"
        data-token="{{ csrf_token() }}"
        data-books="{{ json_encode($books) }}"
        data-errors="{{ json_encode($errors->all()) }}"></div>
</body>
</html>
