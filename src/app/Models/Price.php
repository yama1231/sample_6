<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'accommodation_plan_id',
        'room_type_id',
        'price',
    ];

    public function accommodationPlan(){
        return $this->belongsTo(AccommodationPlan::class);
    }
    public function roomType(){
        return $this->belongsTo(RoomType::class);
    }
}
