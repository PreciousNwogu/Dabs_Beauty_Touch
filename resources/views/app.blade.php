<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dab's Beauty Touch</title>
    <link rel="icon" href="{{ asset('images/icon.ico.jpg') }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=DM+Sans:400,400i,500,500i,700,700i&display=swap">
    @vite(['resources/css/app.css', 'resources/js/App.tsx'])
</head>
<body>
    <div id="app"></div>
</body>
</html>
