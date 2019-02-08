<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>SIPA</title>
</head>
<body>
    <div id="app">
        <div class="container">
            <sipa></sipa>
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
