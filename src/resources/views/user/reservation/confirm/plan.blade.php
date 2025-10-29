@extends('layouts.user-header')
@section('content')
    {{-- <body class="font-sans antialiased"> --}}
    <div class="min-h-screen bg-gray-100">
        <form action="{{ route('user.reservation.confirmUser')}}" method="GET">
            <br>
            <h4>ご予約内容：</h4>
            <br>
            <div class="mb-3">
                <label class="form-label">宿泊プラン：</label>
                <br>
                <p>{{ session('plan_name') }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">部屋タイプ：</label>
                <br>
                <p>{{ session('room_type_name') }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">料金：</label>
                <br>
                <p>{{ session('price') }}円</p>
            </div>
            <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">次へ</button>
            <a href="{{ route('user.top') }}" class="btn btn-secondary">キャンセル</a>
        </div>
        </form>
    </div>
@endsection
    {{-- </body> --}}

