@extends('layouts.user-header')
@section('content')
    {{-- <body class="font-sans antialiased"> --}}
    <div class="min-h-screen bg-gray-100">
        <form action="{{ route('user.reservation.complete')}}" method="post">
            @csrf
            <br>
            <h4>宿泊者情報：</h4>
            <br>
            <div class="mb-3">
                <label class="form-label">お名前：</label>
                <br>
                <p>{{ session('lastname') }}&nbsp;{{ session('firstname') }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">メールアドレス：</label>
                <br>
                <p>{{ session('email') }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">住所：</label>
                <br>
                <p>{{ session('address') }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">電話番号：</label>
                <br>
                <p>{{ session('tel') }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">ご意見、ご要望など：</label>
                <br>
                <p>{{ session('message') }}</p>
            </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">次へ</button>
            <a href="{{ route('user.top') }}" class="btn btn-secondary">キャンセル</a>
        </div>
        </form>
    </div>
@endsection
    {{-- </body> --}}

