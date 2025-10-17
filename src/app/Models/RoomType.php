<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_room_count',
    ];

    public function reservationSlots(){
        return $this->hasMany(ReservationSlot::class);
    }
}
