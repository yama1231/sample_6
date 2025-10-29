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
    // ＊プラン金額が変わっても保持
    public function up()
    {
        Schema::create('user_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('address');
            $table->integer('tel');
            $table->string('plan_name');//プラン名nameを登録＊
            $table->string('room_type_name');//部屋種別名nameを登録＊
            $table->integer('price');//紐づけずにそのまま登録＊
            $table->string('user_message')->nullable();
            $table->string('admin_memo')->nullable();
            $table->integer('delete_flag')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_reservations');
    }
};
