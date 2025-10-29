<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Models\AccommodationPlan;
use App\Models\RoomType;
use App\Models\Price;
use App\Models\ReservationSlot;
use App\Models\UserReservation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

// use Illuminate\Support\Facades\Mail; 

class UserReservationController extends Controller
{
    public function create(Request $request)
    {
        // バリデーション
        // $validated = $request->validate([
        //     'lastname' => 'required|max:255',
        //     'firstname' => 'required|max:255',
        //     'email' => 'required|max:255',
        //     'address' => 'required|max:255',
        //     'tel' => 'required|max:255',
        //     'message' =>'required|max:255',
        //     'title' => 'required|max:255',
        // ]);
        
        // $reservationSlotId = $request->query('reservation_slot_id');
        $planId = $request->query('plan_id');
        $roomTypeId = $request->query('room_type_id');
        
        // Log::info($reservationSlotId);
        
        $plan = AccommodationPlan::findOrFail($planId);
        $roomType = RoomType::findOrFail($roomTypeId);
        $price = Price::where('accommodation_plan_id', $planId)
            ->where('room_type_id', $roomTypeId)
            ->first();
        
        // セッションに保存
        session([
            // 'plan_id' => $request->query('plan_id'),
            // 'room_type_id' => $request->query('room_type_id'),
            'reservation_slot_id' => $request->query('reservation_slot_id'),
            'plan_name' => $plan->title,
            'room_type_name' => $roomType->name,
            'price' => $price->price,
        ]);

        

        return view('user.reservation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmPlan(Request $request)
    {
        
        session([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'address' => $request->address,
            'tel' => $request->tel,
            'message' => $request->message,
        ]);

        return view('user.reservation.confirm.plan');
    }

    public function confirmUser(Request $request)
    {

        // // セッションに保存
        // session([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'title' => $request->title,
        //     'detail' => $request->detail,
        // ]);
        return view('user.reservation.confirm.user_detail');
    }


    public function complete()
    {
        UserReservation::create([
            'lastname' => session('lastname'),
            'firstname' => session('firstname'),
            'email' => session('email'),
            'address' => session('address'),
            'tel' => session('tel'),
            'plan_name' => session('plan_name'),
            'room_type_name' => session('room_type_name'),
            'price' => session('price'),
            'user_message' => session('message'),
        ]);

        $slotId = session('reservation_slot_id');
        ReservationSlot::where('id', $slotId)
            ->decrement('available_rooms');
        
        $session_data = session()->only(['lastname','firstname','email','plan_name','room_type_name','price']);
        // ユーザへ送信
        Mail::to($session_data['email'])->send(new ContactMail('user.reservation.email', '予約が完了しました', $session_data));
        // 管理者へ送信
        Mail::to('admin@example.com')->send(new ContactMail('user.reservation.admin_email', '予約を受け付けました', $session_data));
        
        return redirect()->route('user.top')
            ->with('success','予約枠を作成しました');//モーダルを出す
    }

}
