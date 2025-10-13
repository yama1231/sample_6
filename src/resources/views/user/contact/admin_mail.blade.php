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
<h1>{{$data["name"]}}様からの、お問い合わせを受信しました。</h1>

<p>メールアドレス: {{$data["email"]}}</p>
<p>内容:  {{$data["detail"]}}</p>
</body>