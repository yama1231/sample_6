<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', '宿泊予約') }}</title>

        <!-- Google Fonts: Noto Sans JP -->
        {{--  Google Fontsのメインサーバへの事前接続  
        - `googleapis.com` = 「どこにフォントがあるか」を教えるサーバー
        - `gstatic.com` = 「実際のフォントファイル」を置いているCDNサーバー--}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        {{-- フォントファイル本体が置かれているCDNサーバーへの事前接続 --}}
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        {{-- フォントのダウンロード --}}
        <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;500;700&display=swap" rel="stylesheet">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            {{-- <main class="py-4">
                @yield('content')
            </main> --}}
        </div>
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
