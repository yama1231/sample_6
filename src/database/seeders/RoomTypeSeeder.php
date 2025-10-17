<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\RoomType::create([
            'name' => 'プレミアムルーム(a)',
            'base_room_count' => 2,
        ]);

        \App\Models\RoomType::create([
            'name' => 'スタンダード ツインルーム(b)',
            'base_room_count' => 4,
        ]);

        \App\Models\RoomType::create([
            'name' => 'スタンダード(c)',
            'base_room_count' => 5,
        ]);
    }
}
