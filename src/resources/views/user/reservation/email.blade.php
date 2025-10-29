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
    <title>{{ $data['title'] ?? 'ご宿泊の予約が確定しました' }}</title>
</head>
<body>
<p>{{$data["lastname"]}}&nbsp;{{$data["firstname"]}}&nbsp;様</p>
<br>
<br>
<p>この度はご予約をいただき、ありがとうございます。</p>
<p>以下で、ご予約を承りました。</p>
<br>
<p>宿泊プラン：{{$data["plan_name"]}}</p>
<p>部屋タイプ：{{$data["room_type_name"]}}</p>
<p>料金：{{$data["price"]}}&nbsp;円</p>
<br>
<p>ご来館をお待ちしております。</p>
</body>