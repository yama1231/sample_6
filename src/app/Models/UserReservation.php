<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReservation extends Model
{
    use HasFactory;

    protected $casts = [
        'reservation_date' => 'date',
    ];

    protected $fillable = [
        'lastname',
        'firstname',
        'email',
        'address',
        'tel',
        'reservation_date',
        'plan_name',
        'room_type_name',
        'price',
        'user_message',
        'reservation_slot_id',
    ];
}
