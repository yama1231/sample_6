<!DOCTYPE html>
<html>
<style>
    h1 {
    font-size: 18px;
    }
    p {
    font-size: 14px;
    }
</style>
<head>
    <meta charset="utf-8">
    <title>{{ $data['title'] ?? '予約受け付け' }}</title>
</head>
<body>
<h1>予約内容：</h1>
<br>
<p>宿泊者名:{{$data["lastname"]}}{{$data["firstname"]}}</p>
<p>メールアドレス: {{$data["email"]}}</p>
<p>宿泊プラン：{{$data["plan_name"]}}</p>
<p>部屋タイプ：{{$data["room_type_name"]}}</p>
<p>料金：{{$data["price"]}}&nbsp;円</p>
</body>