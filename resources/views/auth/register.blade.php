<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - NgawiLibrary</title>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/register.jsx'])
</head>
<body>
    <div id="app"
        data-token="{{ csrf_token() }}"
        data-errors="{{ json_encode($errors->all()) }}"></div>
</body>
</html>
