<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>予約リマインド</title>
</head>
<body>
    <h2>ご予約のリマインド</h2>
    <p>明日のご予約についてお知らせいたします。</p>
    
    <div class="card" style="padding: 20px; border: 1px solid #ddd; margin: 20px 0;">
        <p><strong>予約日時：</strong>{{ $reservation->reservation_date }}</p>
        <p><strong>お名前：</strong>{{ $reservation->name }}</p>
    </div>
    
    <p>ご来店をお待ちしております。</p>
</body>
</html>