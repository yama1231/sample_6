<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\ReservationSlot;

class ReservationSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roomTypes = [1,2,3];
        $startDate = Carbon::create(2025,11,1);

        foreach($roomTypes as $roomType){
            for($i = 0; $i < 30; $i++){
                ReservationSlot::create([
                    'reservation_date' => $startDate->copy()->addDays($i),
                    'room_type_id' => $roomType,
                    'available_rooms' => 3,
                ]);
            }
        }
    }
}
