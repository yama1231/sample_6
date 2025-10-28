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
    // 本番用
    // public function index(Request $request)
    // {
    //     $ym = $request->input('ym', Carbon::now()->format('Y-m'));
    //     $plan_id = $request->plan_id;
    //     $plan = AccommodationPlan::with('prices')->findOrFail($plan_id);
    //     // Carbonクラス（日付オブジェクト）に変換しておく
    //     $date = Carbon::createFromFormat('Y-m', $ym)->startOfMonth();
    //     $html_title = $date->isoFormat('YYYY年 M月');
    //     $prev = $date->copy()->subMonth()->format('Y-m');
    //     $next = $date->copy()->addMonth()->format('Y-m');
    //     $roomTypes = RoomType::all();
    //     // デフォルトは部屋タイプID=1とする
    //     $selectedRoomTypeId = 1;
    //     $price = Price::where('accommodation_plan_id',$plan_id)
    //     ->where('room_type_id', $selectedRoomTypeId)
    //     ->first();
    //     // カレンダー生成
    //     $weeks = $this->generateCalendar($date, $selectedRoomTypeId);
    //     return view('user.accommodation-plan.calendar', compact('html_title', 'prev', 'next', 'weeks', 'roomTypes', 'selectedRoomTypeId','plan','price'));
    // }


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
        // // 本番用
        // // // まだ'2025-10'という文字列
        // $ym = $request->input('ym',Carbon::now()->format('Y-m'));
        // $roomTypeId = $request->input('room_type_id', 1);
        // // Carbonオブジェクトに変換
        // $date = Carbon::createFromFormat('Y-m', $ym)->startOfMonth();
        // $weeks = $this->generateCalendar($date, $roomTypeId);

        // return response()->json([
        //     'success' => true,
        //     'weeks' =>$weeks
        // ]);




        // テスト用
        $ym = $request->input('ym',Carbon::now()->format('Y-m'));
        $roomTypeId = $request->input('room_type_id', 1);
        $plan_id = $request->input('plan_id', 1);//1つしかないが、一応
        // var_dump("aaa");
        $room_type = RoomType::where('id', $roomTypeId)->first();//Postmanにfindダメって言われた。後で調べる
        // var_dump($room_type);
        $room_type_name = $room_type->name;
        // var_dump($room_type_name);
        $price_instance = Price::with('roomType')
        ->where('accommodation_plan_id',$plan_id)
        ->where('room_type_id', $roomTypeId)
        ->first();//名前が酷すぎる。後で変える
        // var_dump($price_instance);
        $price = $price_instance->price;
        // var_dump($price);
        // Carbonオブジェクトに変換
        $date = Carbon::createFromFormat('Y-m', $ym)->startOfMonth();
        // $weeks = $this->generateCalendar($date, $roomTypeId); 本番用
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
            ->keyBy('reservation_date');//下で日付ごとの空き部屋を取得
        
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


            // 最初は種別１（デフォ）の予約枠の空き部屋数
            //上で宣言しているがwarning対策のために宣言及びnullチェック
            if(isset($slots[$dateKey])){
                $availableRooms = $slots[$dateKey]->available_rooms ?? 0;
                if($availableRooms >= 2){
                    $statusSymbol = '◯';
                }elseif($availableRooms == 1){
                    $statusSymbol = '△';
                }else{
                    $statusSymbol = '×';
                }
            }
            // 本番用
            // $week[] = "<td class='calendar-cell{$todayClass}{$holidayClass}'>
            //     <div class='date-number'>{$day}</div>
            //     <div class='availability-status'>{$statusSymbol} {$availableRooms}室</div>
            // </td>";

            
            // "<a href="{{ route('user.calendar', ['plan_id' => $plan->id]) }}">予約する</a>"
            // $btn_route = "{{ route('user.top', $plan_id ]}}";
            $btn_route = 'http://localhost:8080/top';//get送信
            // $aaa = "<a href="http://localhost:8080/accommodation-plans/calendar?plan_id=1">Visit W3Schools</a>";
            // テスト用.   もしかして文字列を入れられない？
            $week[] = "
                <td class='calendar-cell{$todayClass}{$holidayClass}'>
                    <div class='date-number'>{$day}</div>
                    <div class='availability-status'>{$statusSymbol} {$availableRooms}室</div>
                    <a href='{$btn_route}'>予約する</a>
                </td>
            ";

            // $week[] = "<td class='{$todayClass}{$holidayClass}'>
            //     {$day}<br>. .  a.   </td>";
            
            // $week[] = "<td class='{$todayClass}{$holidayClass}'>{$day}</td>";

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
        // 簡易例：固定祝日のみ　　　
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