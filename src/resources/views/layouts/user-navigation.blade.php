<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- <title>@yield('title', 'デフォルトタイトル')</title> --}}
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav>
        <a href="{{ route('user.top') }}" class="hidden space-x-8 sm:-my-px sm:flex sm:items-center font-medium text-xl text-gray-900 hover:text-gray-700 transition">
            宿泊サイト
        </a>

        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <a href="{{ route('user.accommodation-plan.top') }}">
                {{ __('宿泊プラン') }}
            </a>
            <a href="{{ route('user.access') }}">
                {{ __('客室紹介') }}
            </a>
            <a href="{{ route('user.access') }}">
                {{ __('アクセス') }}
            </a>
            <a href="{{ route('user.contact.index') }}">
                {{ __('お問い合わせ') }}
            </a>
            {{-- <a href="route('user.contact.index')">
                {{ __('お問い合わせ') }}
            </a> --}}
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
