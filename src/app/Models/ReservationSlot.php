<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationSlot extends Model
{
    use HasFactory;

    //  これで不都合ないか、挙動を見てから判断
    protected $fillable = [
        'reservation_date',
        'room_type_id',
        'available_rooms'
    ];
    //  10/15 チャプター９の時点では使用しないが、チャプター１３の予約時にフォーマット変換しそうなので定義しておく
    protected $casts = [
        'reservation_date' => 'date',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
