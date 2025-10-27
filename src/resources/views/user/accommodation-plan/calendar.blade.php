@extends('layouts.user-header')

@section('title', 'カレンダー')

@section('styles')
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    {{-- カレンダー専用CSS --}}
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endsection

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
<div class="container calendar-wrapper">


    {{-- 本番用 --}}
        {{-- <div> 
            <br>
            <p>ご選択中のプラン：{{$plan->title}}</p>
            <p id="roomTypeName">部屋タイプ：{{$roomTypes[$selectedRoomTypeId]->name}}</p>
            <p id="price">料金：{{$price->price}}円</p>
        </div> --}}
    

        {{-- テスト用 --}}
        <div>
            <br>
            <p>選択中のプラン：{{$plan->title}}</p>
            <p id="roomTypeName">部屋タイプ：{{$room_type_name}}</p>
            <p id="price">料金：{{$price->price}}円</p>
        </div>




    <div class="calendar-card">
        <div class="room-type-selector mb-4">
            <h5>部屋タイプを選択</h5>
            <div class="btn-group" role="group" aria-label="部屋タイプ選択">
                @foreach($roomTypes as $roomType)
                    <input 
                        type="radio"
                        class="btn-check"
                        name="room_type"
                        id="roomType{{ $roomType->id }}"
                        value="{{ $roomType->id }}"
                        autocomplete="off" 
                        {{ $roomType->id == $selectedRoomTypeId ? 'checked' : '' }}
                    >
                    <label class="btn btn-outline-primary" for="roomType{{ $roomType->id }}">
                        {{ $roomType->name}}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="calendar-header">
            <div class="calendar-nav">
                {{-- <a href="?ym={{ $prev }}" class="nav-btn">&lt;</a>
                <h2 class="calendar-title">{{ $html_title }}</h2>
                <a href="?ym={{ $next }}" class="nav-btn">&gt;</a> --}}
                <a href="#" class="nav-btn" id="prevMonth" data-ym="{{ $prev }}">&lt;</a>
                <h2 class="calendar-title" id="calendarTitle">{{ $html_title }}</h2>
                <a href="#" class="nav-btn" id="nextMonth" data-ym="{{ $next }}">&gt;</a>
            </div>
        </div>

        <div class="calendar-body">
            <div class="table-responsive">
                <table class="table table-bordered calendar-table">
                    <thead>
                        <tr>
                            <th>日</th>
                            <th>月</th>
                            <th>火</th>
                            <th>水</th>
                            <th>木</th>
                            <th>金</th>
                            <th>土</th>
                        </tr>
                    </thead>
                    <tbody id="calendarBody">
                        {!! implode('', $weeks) !!}
                    </tbody>
                </table>
            </div>
        </div>

        <div id="loadingOverlay" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">loading...</span>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // <- NodeList foreach/forが使える
        // CSSセレクタは色々選べる->
        const roomTypeInputs = document.querySelectorAll('input[name="room_type"]');//回して３つある
        const calendarBody = document.getElementById('calendarBody');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        const calendarTitle = document.getElementById('calendarTitle');


        // test
        const roomTypeName = document.getElementById('roomTypeName')
        const price = document.getElementById('price')

        // 本番用
        // 部屋タイプ変更時の処理
        // roomTypeInputs.forEach(input => {
        //     input.addEventListener('change', function(){
        //         const roomTypeId = this.value;
        //         const currentYmFromNav = getCurrentYmFromTitle();
        //         loadCalendar(currentYmFromNav, roomTypeId);
        //     });
        // })


        // テスト用
        // 部屋タイプ変更時の処理.  ３つあるラジオボタンを押されたら更新する
        roomTypeInputs.forEach(input => {
            input.addEventListener('change', function(){
                const roomTypeId = this.value;
                const currentYmFromNav = getCurrentYmFromTitle();
                loadCalendar(currentYmFromNav, roomTypeId);
            });
        })


        // 前月ボタン   click  
        prevMonthBtn.addEventListener('click', function(e) {
            e.preventDefault();//上部スクロール防止
            const ym = this.dataset.ym;
            const roomTypeId = getSelectedRoomType();
            loadCalendar(ym, roomTypeId);
        });

        // 次月ボタン   click
        nextMonthBtn.addEventListener('click', function(e) {
            e.preventDefault();//上部スクロール防止
            const ym = this.dataset.ym;
            const roomTypeId = getSelectedRoomType();
            loadCalendar(ym, roomTypeId);
        });

        // 本番用
        // カレンダーデータ取得＋calendarBody.innerHTMLで更新
        // function loadCalendar(ym, roomTypeId) {
        //     showLoading();
        //     fetch(`{{ route('user.calendar.data') }}?ym=${ym}&room_type_id=${roomTypeId}`)
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.success) {
        //             calendarBody.innerHTML = data.weeks.join('');
        //             updateNavigation(ym);
        //         }
        //     })
        //     .catch(error => {
        //         console.error('Error:', error);
        //         alert('カレンダーの読み込みに失敗しました');
        //     })
        //     .finally(() => {
        //         hideLoading();
        //     });
        // }




        // テスト用 plan_idは元々持ってるから別途送らなくてよい
        // カレンダーデータ取得＋calendarBody.innerHTMLで更新
        function loadCalendar(ym, roomTypeId) {
            showLoading();
            fetch(`{{ route('user.calendar.data') }}?ym=${ym}&room_type_id=${roomTypeId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    calendarBody.innerHTML = data.weeks.join('');
                    const room_type_name = data.room_type_name;
                    const aaa = data.room_type_name;
                    roomTypeName.textContent =`部屋タイプ：${room_type_name}`;
                    price.textContent = `料金：${data.price}円`;
                    updateNavigation(ym);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('カレンダーの読み込みに失敗しました');
            })
            .finally(() => {
                hideLoading();
            });
        }






        // ナビゲーション更新
        function updateNavigation(ym) {
            const [year, month] = ym.split('-');
            const date = new Date(year, month - 1, 1);
            
            // タイトル更新
            calendarTitle.textContent = `${year}年 ${month}月`;
            
            // 前月・次月の年月計算
            const prevDate = new Date(date);
            prevDate.setMonth(prevDate.getMonth() - 1);
            const prevYm = `${prevDate.getFullYear()}-${String(prevDate.getMonth() + 1).padStart(2, '0')}`;
            
            const nextDate = new Date(date);
            nextDate.setMonth(nextDate.getMonth() + 1);
            const nextYm = `${nextDate.getFullYear()}-${String(nextDate.getMonth() + 1).padStart(2, '0')}`;
            
            prevMonthBtn.dataset.ym = prevYm;
            nextMonthBtn.dataset.ym = nextYm;
        }

        // 選択中の部屋タイプID取得
        function getSelectedRoomType() {
            return document.querySelector('input[name="room_type"]:checked').value;
        }
        
        // タイトルから現在の年月を取得
        function getCurrentYmFromTitle() {
            const title = calendarTitle.textContent;
            const match = title.match(/(\d{4})年\s*(\d{1,2})月/);
            if (match) {
                const year = match[1];
                const month = String(match[2]).padStart(2, '0');
                return `${year}-${month}`;
            }
            return '{{ Carbon\Carbon::now()->format("Y-m") }}';
        }

        // ローディング表示
        function showLoading() {
            loadingOverlay.style.display = 'flex';
        }
        
        // ローディング非表示
        function hideLoading() {
            loadingOverlay.style.display = 'none';
        }
    });
</script>

<style>
    
.room-type-selector {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.calendar-cell {
    position: relative;
    height: 80px;
    vertical-align: top;
    padding: 8px;
}

.date-number {
    font-weight: bold;
    font-size: 16px;
}

.availability-status {
    margin-top: 8px;
    font-size: 14px;
    color: #666;
}

#loadingOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
</style>

@endsection