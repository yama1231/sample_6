<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>件名</th>
                    <th>氏名</th>
                    <th>お問合せ日</th>
                    <th>対応状況</th>
                    <th>ステータス変更</th>
                </tr>
            </thead>
            <tbody>
            
                <tr>
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->title }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->created_at }}</td>
                    @if ($contact->status == 0)
                        <td>未対応</td>
                    @elseif ($contact->status == 1)
                        <td>対応中</td>
                    @elseif ($contact->status == 2)
                        <td>対応済み</td>
                    @endif
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            変更
                        </button>
                    </td> 
                    {{-- <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            詳細
                        </button>
                    </td> --}}
                </tr>

                <!-- モーダル本体 -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $contact->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                対応ステータスの変更が可能です。
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('dashboard_edit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">
                                        変更しない
                                    </button>
                                    <button type="submit" name="status" value="0" class="btn btn-primary">
                                        未対応
                                    </button>
                                    <button type="submit" name="status" value="1" class="btn btn-primary">
                                        対応中
                                    </button>
                                    <button type="submit" name="status" value="2" class="btn btn-primary">
                                        完了
                                    </button>
                                </form> 
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </tbody>
        </table>
        <a href="{{ route('dashboard') }}" class="hidden space-x-8 sm:-my-px sm:flex sm:items-center font-medium text-xl text-gray-900 hover:text-gray-700 transition">
            ダッシュボードへ戻る
        </a>
        </div>
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>

        