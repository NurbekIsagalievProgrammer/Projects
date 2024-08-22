<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TransactionHistory') }}</title>
     <!-- Подключение скрипта Vue.js -->
     @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <!-- Ваш компонент Vue.js будет монтироваться здесь -->
    <div id="app">
        <transaction-history></transaction-history>
    </div>

   
</body>
</html>
