<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ling</title>

    @vite(['resources/auth/css/app.css', 'resources/auth/scss/app.scss', 'resources/auth/js/app.js'])
</head>
<body class="text-gray-900 antialiased font-['Roboto',_sans-serif]">
<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
    <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-xl">
        <div class="flex justify-center mb-4">
            <a href="{{ route('post.index') }}">
                <img class="logo" src="{{ asset('assets/web/images/logo/logo.svg') }}" alt="Ling">
            </a>
        </div>
        @yield('content')
    </div>

</div>
</body>
</html>
