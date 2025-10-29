<?php

namespace App\Http\Controllers;

use App\Models\ReservationSlot;
use App\Models\AccommodationPlan;
use App\Models\RoomType;
use App\Models\Price;
use Illuminate\Http\Request;
use Carbon\Carbon;
use \Yasumi\Yasumi;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $ym = $request->input('ym', Carbon::now()->format('Y-m'));
        $plan_id = $request->plan_id;
        $plan = AccommodationPlan::with('prices')->findOrFail($plan_id);
        // Carbonクラス（日付オブジェクト）に変換しておく
        $date = Carbon::createFromFormat('Y-m', $ym)->startOfMonth();
        $html_title = $date->isoFormat('YYYY年 M月');
        $prev = $date->copy()->subMonth()->format('Y-m');
        $next = $date->copy()->addMonth()->format('Y-m');
        $roomTypes = RoomType::all();
        // デフォルトは部屋タイプID=1とする
        $selectedRoomTypeId = 1;
        // インスタンス
        $price = Price::where('accommodation_plan_id',$plan_id)
        ->where('room_type_id', $selectedRoomTypeId)
        ->first();
        $room_type = RoomType::where('id', $selectedRoomTypeId)->first();//Postmanにfindダメって言われた。後で調べる
        $room_type_name = $room_type->name;
        // カレンダー生成
        // $weeks = $this->generateCalendar($date, $selectedRoomTypeId); 本番用
        $weeks = $this->generateCalendar($date, $selectedRoomTypeId,$plan_id);
        return view('user.accommodation-plan.calendar', compact('html_title', 'prev', 'next', 'weeks', 'roomTypes', 'selectedRoomTypeId','plan','price','room_type_name'));
    }


    // Ajax
    public function getCalendarData(Request $request)
    {
        $ym = $request->input('ym',Carbon::now()->format('Y-m'));
        $roomTypeId = $request->input('room_type_id', 1);
        $plan_id = $request->input('plan_id', 1);//1つしかないが、一応
        // $room_type = RoomType::where('id', $roomTypeId)->first();
        $room_type = RoomType::find($roomTypeId);
        $room_type_name = $room_type->name;
        $price_instance = Price::with('roomType')
        ->where('accommodation_plan_id',$plan_id)
        ->where('room_type_id', $roomTypeId)
        ->first();
        $price = $price_instance->price;

        // Carbonオブジェクトに変換
        $date = Carbon::createFromFormat('Y-m', $ym)->startOfMonth();
        $weeks = $this->generateCalendar($date, $roomTypeId, $plan_id);

        return response()->json([
            'room_type_name' => $room_type_name,
            'price' => $price,
            'ym' => $ym,
            'success' => true,
            'weeks' =>$weeks
        ]);
    }

    /**
     * カレンダーのHTML生成
     */
    // private function generateCalendar(Carbon $date, $roomTypeId)
    private function generateCalendar(Carbon $date, $roomTypeId, $plan_id)
    {
        $weeks = [];
        $today = Carbon::today();
        
        // 月初めの曜日を取得（0:日曜 〜  6:土曜）
        // 例：startOfMonth()-> date: 2025-10-01
        // 2025-10-01 は水曜日なので、dayOfWeekで３を返す
        $firstDayOfWeek = $date->copy()->startOfMonth()->dayOfWeek;
        // 月の日数 31日
        $daysInMonth = $date->daysInMonth;
        // 週のカウンター
        $week = [];
        // 月初めまでの空白セルを追加
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $week[] = '<td></td>';
        }
        // 当月と翌月の予約枠を取得
        $startOfThisMonth = $date->copy()->startOfMonth();
        // $endOfNextMonth = $date->copy()->addMonth()->endOfMonth();
        $endOfThisMonth = $date->copy()->endOfMonth();

        $slots = ReservationSlot::with('roomType')
            ->where('room_type_id', $roomTypeId)
            ->whereBetween('reservation_date',[$startOfThisMonth, $endOfThisMonth])
            ->get()
            ->keyBy(function($slot) {
            // Carbonオブジェクトを文字列形式に変換してキーとする(日付で部屋数を確認する)
            return $slot->reservation_date->format('Y-m-d');
            });
        // 日付セル
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = $date->copy()->day($day);
            // 今日か判定
            $todayClass = $currentDate->isSameDay($today) ? ' today' : '';
            // あと祝日かも判定
            $holidayClass = $this->isHoliday($currentDate) ? ' holiday' : '';
            //当日の空き部屋数(デフォルトは満室とする)
            $dateKey = $currentDate->format('Y-m-d');
            $availableRooms = 0;
            $statusSymbol = '×';
            $linkActive = 'disabled';
            $btn_route = '#';//get送信

            if(isset($slots[$dateKey])){
                $availableRooms = $slots[$dateKey]->available_rooms ?? 0;
                if($availableRooms >= 2){
                    $statusSymbol = '◯';
                    $btn_route = 'http://localhost:8080/reservation/create';
                    $linkActive = '';
                }elseif($availableRooms == 1){
                    $statusSymbol = '△';
                    $btn_route = 'http://localhost:8080/reservation/create';
                    $linkActive = '';
                }else{
                    $statusSymbol = '×';
                    $btn_route = '#';
                    $linkActive = 'disabled';
                }
            }

            $week[] = "
                <td class='calendar-cell{$todayClass}{$holidayClass}'>
                    <div class='date-number'>{$day}</div>
                    <div class='availability-status'>{$statusSymbol} {$availableRooms}室</div>
                    <a href='{$btn_route}'class='{$linkActive}'>予約する</a>
                </td>
            ";

            // 土曜日の場合、行を閉じて新しい週を開始
            if ($currentDate->dayOfWeek === Carbon::SATURDAY) {
                $weeks[] = '<tr>' . implode('', $week) . '</tr>';
                $week = [];
            }
        }

        // 最終週の残りを空白で埋める
        if (!empty($week)) {
            $remainingDays = 7 - count($week);
            for ($i = 0; $i < $remainingDays; $i++) {
                $week[] = '<td></td>';
            }
            $weeks[] = '<tr>' . implode('', $week) . '</tr>';
        }
        
        return $weeks;
    }
    
    /**
     * 祝日判定（オプション）
     */
    private function isHoliday(Carbon $date)
    {
        // 簡易例：固定の場合
        // $holidays = [
        //     '01-01', // 元日
        //     '02-11', // 建国記念日
        //     '04-29', // 昭和の日
        //     '05-03', // 憲法記念日
        //     '05-04', // みどりの日
        //     '05-05', // こどもの日
        //     '11-03', // 文化の日
        //     '11-23', // 勤労感謝の日
        // ];
        // return in_array($date->format('m-d'), $holidays);
        
        $year = $date->year;
        $holidays = Yasumi::create('Japan', $year,'ja_JP');
        // 出力はできているけど、上記の$holidaysと形式が異なるためフォーマットする必要がある
        return $holidays->isHoliday($date->toDateTime());
    }
}