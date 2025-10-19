<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'accommodation_plan_id',
        'image_path',
        'display_order',
    ];

    public function accommodationPlan(){
        return $this->belongsTo(accommodationPlan::class);
    }
}
