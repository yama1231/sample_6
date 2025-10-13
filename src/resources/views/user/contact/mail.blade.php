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
    <title>{{ $data['title'] ?? 'お問い合わせ' }}</title>
</head>
<body>
<h1>{{$data["name"]}}様</h1>
<br><br>
<p>この度はお問合せをいただき、誠にありがとうございます。</p>
<p>担当者よりご連絡をいたしますので、今しばらくお待ちください。</p>
<br><br>
<p>メールアドレス: {{$data["email"]}}</p>
<p>内容:  {{$data["detail"]}}</p>
</body>