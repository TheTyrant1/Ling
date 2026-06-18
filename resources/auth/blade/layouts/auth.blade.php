<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    @vite(['resources/auth/css/app.css', 'resources/auth/scss/app.scss', 'resources/auth/js/app.js'])
</head>
<body class="text-gray-900 antialiased">
<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
    <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-xl">
        <div class="flex justify-center">
            <a href="{{ route('post.index') }}">
                <img src="{{ asset('assets/auth/images/logo/logo.svg') }}" alt="Ling" class="object-contain">
            </a>
        </div>
        @yield('content')
    </div>

</div>
</body>
</html>
