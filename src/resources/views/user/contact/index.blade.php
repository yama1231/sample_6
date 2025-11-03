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
                <label for="name" class="form-label @error('name') is-invalid @enderror">お名前</label>
                <input type="text" name="name" class="form-control" id="email" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label @error('email') is-invalid @enderror">メールアドレス</label>
                <input type="text" name="email" class="form-control" id="email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="title" class="form-label @error('title') is-invalid @enderror">件名</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label @error('detail') is-invalid @enderror">お問い合わせ内容</label>
                <textarea class="form-control" name="detail" id="detail" rows="3">{{ old('detail') }}</textarea>
                @error('detail')
                    <div class="invalid-feedback">
                        {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">次へ</button>
        </form>

    </div>
@endsection
    {{-- </body> --}}

