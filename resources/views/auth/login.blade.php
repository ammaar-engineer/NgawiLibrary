<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - NgawiLibrary</title>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/login.jsx'])
</head>
<body>
    <div id="app"
        data-token="{{ csrf_token() }}"
        data-email="{{ old('email') }}"
        data-errors="{{ json_encode($errors->all()) }}"></div>
</body>
</html>
