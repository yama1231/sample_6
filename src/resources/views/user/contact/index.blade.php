@extends('layouts.user-header')
@section('content')
    {{-- <body class="font-sans antialiased"> --}}
    <div class="min-h-screen bg-gray-100 m-3">
        <a class="text-decoration-none text-dark" href="{{ route('user.top') }}">
            <h4 class="m-2">お問い合わせ</h4>
        </a>
        <form action="{{ route('user.contact.confirm')}}" method="post">
            @csrf
            <br>
            <div class="mb-3">
                <label for="name" class="form-label">お名前</label>
                <input type="text" name="name" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="text" name="email" class="form-control" id="email">
                {{-- type="email"  --}}
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">件名</label>
                <input type="text" name="title" class="form-control" id="title">
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">お問い合わせ内容</label>
                <textarea class="form-control" name="detail" id="detail" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">次へ</button>
        </form>

    </div>
@endsection
    {{-- </body> --}}

