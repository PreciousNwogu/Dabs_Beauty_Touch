<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dab's Beauty Touch</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icon.ico.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icon.ico.jpg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icon.ico.jpg') }}">
    <meta name="msapplication-TileImage" content="{{ asset('images/icon.ico.jpg') }}">
    
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=DM+Sans:400,400i,500,500i,700,700i&display=swap">
    @vite(['resources/css/app.css', 'resources/js/App.tsx'])
</head>
<body>
    <div id="app"></div>
</body>
</html>
