<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'description',
        'room_slot_id',
        'reservation_slot_id',
    ];

    public function images(){
        return $this->hasMany(PlanImage::class)->orderBy('display_order');
    }

    public function prices(){
        return $this->hasMany(Price::class);
    }

}
