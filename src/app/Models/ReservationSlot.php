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

        protected $casts = [
        'reservation_date' => 'date',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
