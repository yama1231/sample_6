<!doctype html>
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
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
<body>
    <nav>
        <a class="text-decoration-none text-dark" href="{{ route('user.top') }}">
            <h3 class="m-3">宿泊サイト</h3>
        </a>

        <!-- Navigation Links -->
        <div class="d-flex justify-content-start align-items-center py-3 mx-3">
            <a class="mx-1"  href="{{ route('user.accommodation-plan.top') }}">
                {{ __('宿泊プラン') }}
            </a>
            <a class="mx-1" href="{{ route('user.access') }}">
                {{ __('客室紹介') }}
            </a>
            <a class="mx-1" href="{{ route('user.access') }}">
                {{ __('アクセス') }}
            </a>
            <a class="mx-1" href="{{ route('user.contact.index') }}">
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
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
