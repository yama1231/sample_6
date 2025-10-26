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
        // $roomTypes = [1,2,3];
        // $startDate = Carbon::create(2025,11,1);

        // foreach($roomTypes as $roomType){
        //     for($i = 0; $i < 30; $i++){
        //         ReservationSlot::create([
        //             'reservation_date' => $startDate->copy()->addDays($i),
        //             'room_type_id' => $roomType,
        //             'available_rooms' => 3,
        //         ]);
        //     }
        // }

        $startDate_1 = Carbon::create(2025,9,1);
        $startDate_2 =  Carbon::create(2025,10,1);
        $startDate_3 = Carbon::create(2025,11,1);

        for($i = 0; $i < 30; $i++){
                ReservationSlot::create([
                    'reservation_date' => $startDate_1->copy()->addDays($i),
                    'room_type_id' =>  1,
                    'available_rooms' => 3,
                ]);
        }

        for($i = 0; $i < 31; $i++){
                ReservationSlot::create([
                    'reservation_date' => $startDate_2->copy()->addDays($i),
                    'room_type_id' =>  2,
                    'available_rooms' => 4,
                ]);
        }

        for($i = 0; $i < 30; $i++){
                ReservationSlot::create([
                    'reservation_date' => $startDate_3->copy()->addDays($i),
                    'room_type_id' =>  3,
                    'available_rooms' => 5,
                ]);
        }
    }
}
