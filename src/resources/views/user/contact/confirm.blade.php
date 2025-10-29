@extends('layouts.user-header')
@section('content')
    {{-- <body class="font-sans antialiased"> --}}
    <div class="min-h-screen bg-gray-100">
        <form action="{{ route('user.contact.complete')}}" method="post">
            @csrf
            <br>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">お名前：</label>
                <br>
                <p>{{ session('name') }}</p>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">メールアドレス：</label>
                <br>
                <p>{{ session('email') }}</p>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">件名：</label>
                <br>
                <p>{{ session('title') }}</p>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">お問合せ内容：</label>
                <br>
                <p>{{ session('detail') }}</p>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
    {{-- </body> --}}

