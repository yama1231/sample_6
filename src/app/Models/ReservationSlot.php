<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_date',
        'room_type_id',
        'available_rooms',
    ];
    //  10/15 チャプター９の時点では使用しないが、チャプター１３の予約時にフォーマット変換しそうなので定義しておく
    //  10/18 そのまま画面に持っていくと時刻まで表示されるので、一旦非表示
    // protected $casts = [
    //     'reservation_date' => 'date',
    // ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
