<?php

namespace App\Http\Controllers;

use App\Models\ReservationSlot;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservationSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 一覧
    public function index()
    {
        $reservationSlots = ReservationSlot::with('roomType')
        ->orderBy('reservation_date','asc')
        ->orderBy('room_type_id')
        ->paginate(15);

        return view('admin.reservation_slot.index',compact('reservationSlots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 作成画面へ
    public function create()
    {
        $roomTypes = RoomType::all();
        return view('admin.reservation_slot.create', compact('roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 作成画面で作成したら保存（complete）
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_date' => 'required|date',
            'room_type_id' =>[
                'required',
                'exists:room_types,id',
                Rule::unique('reservation_slots')
                ->where('reservation_date', $request->reservation_date)
            ],
        ],[
            'room_type_id.unique' => 'この日付と部屋の組み合わせはすでに登録されています。',
        ]);

        $roomType = RoomType::findOrFail($validated['room_type_id']);

        ReservationSlot::create([
            'reservation_date' => $validated['reservation_date'],
            'room_type_id' => $validated['room_type_id'],
            'available_rooms' => $roomType->base_room_count,
        ]);

        return redirect()->route('reservation_slots.index')
            ->with('success','予約枠を作成しました');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservationSlot $reservationSlot)
    {
        $roomTypes = RoomType::all();
        return view('admin.reservation_slot.edit', compact('reservationSlot','roomTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservationSlot $reservationSlot)
    {
        $validated = $request->validate([
            'reservation_date' => 'required|date',
            'room_type_id' => [
                'required',
                'exists:room_types,id',
                Rule::unique('reservation_slots')
                    ->where('reservation_date', $request->reservation_date)
                    ->ignore($reservationSlot->id)
            ],
        ], [
            'room_type_id.unique' => 'この日付と部屋の組み合わせはすでに登録されています。',
        ]);
        if($reservationSlot->room_type_id != $validated['room_type_id']){
            $roomType = RoomType::findOrFail($validated['room_type_id']);
            $validated['available_rooms'] = $roomType->base_room_count;
        }
        $reservationSlot->update($validated);

        return redirect()->route('reservation_slots.index')->with('success','予約枠を更新しました。');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservationSlot $reservationSlot)
    {
        $reservationSlot ->delete();
        return redirect()->route('reservation_slots.index')->with('success','予約枠を削除しました。');
    }
}
