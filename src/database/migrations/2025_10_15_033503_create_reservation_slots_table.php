<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_slots', function (Blueprint $table) {
            $table->id();
            $table->date('reservation_date');
            $table->integer('available_rooms');
            $table->foreignId('room_type_id')->constrained('room_types');
            $table->timestamps();

            $table->unique(['reservation_date', 'room_type_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_slots');
    }
};
