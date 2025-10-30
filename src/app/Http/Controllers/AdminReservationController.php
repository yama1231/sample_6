<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\ReservationSlot;
use App\Models\UserReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservationList = UserReservation::orderBy('created_at','desc')->paginate(10);//listで出すならall
        return view('admin.reservation.index', compact('reservationList'));
        
    }

    public function show(UserReservation $reservation)
    {
        return view('admin.reservation.show', compact('reservation'));
        
    }

    public function memo( UserReservation $reservation)
    {
        return view('admin.reservation.memo', compact('reservation'));
        
    }

    public function memo_save(Request $request)
    {
        $admin_memo = $request->admin_memo;
        // dd($memo);
        $reservationId = $request->input('reservation_id');
        // dd($reservationId);
        $reservation = UserReservation::find($reservationId);
        $reservation->admin_memo = $admin_memo;
        $reservation->save();
        // dd($reservation);

        return redirect()->route('reservation.show', $reservationId)->with('success','メモを更新しました。');//modal追加
        
    }
    
    public function cancel(Request $request)
    {
        $reservationId = $request->input('reservation_id');
        $reservation = UserReservation::find($reservationId);
        
        $reservation_slot_id = $reservation -> reservation_slot_id;
        // 予約枠の部屋数を＋１する
        ReservationSlot::where('id',$reservation_slot_id)
        ->increment('available_rooms');

        $reservation->delete_flag = 1;// App\Enumsの下に定数を定義して、マジックナンバーを使う💫
        $reservation->save();

        // メール送信(ユーザへのみ)
        $name = $reservation ->lastname . ' ' . $reservation ->lastname;
        $email = $reservation ->email;
        $data = ['name' => $name];
        Mail::to($email)->send(new ContactMail('admin.reservation.email', '予約キャンセルのご連絡', $data));
        
        return redirect()->route('reservation.index')->with('success','予約をキャンセルしました。');//modal追加
    }

    public function search(Request $request)
    {  
        $keyword = $request->input('keyword');
        $reservationList = UserReservation::query()
            // 最初の$keywordは実行可否の条件(bool)
            // fnの第一引数はクエリビルダ、第二引数は条件時の使用データ
            // whereの最後に；
            ->when($keyword, function($query, $keyword){
                return $query->where('firstname','like',"%{$keyword}%")
                ->orWhere('lastname','like',"%{$keyword}%")
                ->orWhere('email','like',"%{$keyword}%")
                ->orWhere('address','like',"%{$keyword}%")
                ->orWhere('tel','like',"%{$keyword}%")
                ->orWhere('plan_name','like',"%{$keyword}%")
                ->orWhere('room_type_name','like',"%{$keyword}%")
                ->orWhere('user_message','like',"%{$keyword}%")
                ->orWhere('admin_memo','like',"%{$keyword}%")
                ->orWhere('price','like',"%{$keyword}%");
                })
            ->orderBy('created_at', 'desc')
            ->paginate('10');

        return view('admin.reservation.index', compact('reservationList'));
    }
}
