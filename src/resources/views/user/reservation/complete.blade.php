@extends('layouts.user-header')
@section('content')
    <p>{{ session('lastname') }}&nbsp;{{ session('firstname') }}&nbsp;様</p>
    <p>ご予約が確定しました。</p>
    <p>ご利用いただき、ありがとうございます。</p>

    <a href="{{ route('user.top') }}">
        TOPへ戻る
    </a>
@endsection