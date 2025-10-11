@extends('layouts.user-header')
@section('content')
    <p>お問合せありがとうございまず！</p>
    <p>担当者よりご連絡をいたしますので、今しばらくお待ちください。</p>
    <a href="{{ route('user.top') }}" class="hidden space-x-8 sm:-my-px sm:flex sm:items-center font-medium text-xl text-gray-900 hover:text-gray-700 transition">
        TOPへ戻る
    </a>
@endsection