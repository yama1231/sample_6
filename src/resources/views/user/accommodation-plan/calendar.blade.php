@extends('layouts.user-header')

@section('title', 'カレンダー')

@section('styles')
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .calendar-cell {
            height: 100px;
            vertical-align: top;
            position: relative;
        }
        .date-number {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        .availability-status {
            font-size: 0.9rem;
        }
        .today {
            background-color: #e8f4ff; /* Light blue for today */
        }
        .holiday {
            background-color: #fff0f0; /* Light red for holidays */
            color: #dc3545;
        }
        .calendar-nav-btn {
            font-size: 1.2rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background-color 0.2s;
        }
        .calendar-nav-btn:hover {
            background-color: #f0f0f0;
            text-decoration: none;
        }
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(2px);
        }
    </style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <!-- Plan Info Card -->
            <div class="card shadow-sm mb-4 border-0 bg-light">
                <div class="card-body">
                    <h4 class="card-title mb-3 fw-bold text-primary">{{$plan->title}}</h4>
                    <div class="d-flex flex-wrap gap-4 text-secondary">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-house-door me-2"></i>
                            <span id="roomTypeName" class="fw-medium">部屋タイプ：{{$room_type_name}}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-currency-yen me-2"></i>
                            <span id="price" class="fw-medium">料金：{{ number_format($price->price) }}円〜</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Type Selector -->
            <div class="mb-4 text-center">
                <h5 class="mb-3 fw-bold text-secondary">部屋タイプを選択</h5>
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
                        <label class="btn btn-outline-primary px-4 py-2" for="roomType{{ $roomType->id }}">
                            {{ $roomType->name}}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Calendar Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 px-3">
            <a href="#" class="btn btn-outline-secondary rounded-circle p-2" id="prevMonth" data-ym="{{ $prev }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-chevron-left"></i>
            </a>
            <h2 class="h3 fw-bold mb-0 text-dark" id="calendarTitle">{{ $html_title }}</h2>
            <a href="#" class="btn btn-outline-secondary rounded-circle p-2" id="nextMonth" data-ym="{{ $next }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>

            <!-- Calendar Table -->
            <div class="card shadow border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 text-center align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-danger py-3">日</th>
                                    <th class="py-3">月</th>
                                    <th class="py-3">火</th>
                                    <th class="py-3">水</th>
                                    <th class="py-3">木</th>
                                    <th class="py-3">金</th>
                                    <th class="text-primary py-3">土</th>
                                </tr>
                            </thead>
                            <tbody id="calendarBody">
                                {!! implode('', $weeks) !!}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" style="display: none;">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-secondary fw-bold">読み込み中...</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomTypeInputs = document.querySelectorAll('input[name="room_type"]');
        const calendarBody = document.getElementById('calendarBody');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        const calendarTitle = document.getElementById('calendarTitle');
        const roomTypeName = document.getElementById('roomTypeName');
        const price = document.getElementById('price');

        // 部屋タイプ変更時の処理
        roomTypeInputs.forEach(input => {
            input.addEventListener('change', function(){
                const roomTypeId = this.value;
                const currentYmFromNav = getCurrentYmFromTitle();
                loadCalendar(currentYmFromNav, roomTypeId);
            });
        })

        // 前月ボタン
        prevMonthBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const ym = this.dataset.ym;
            const roomTypeId = getSelectedRoomType();
            loadCalendar(ym, roomTypeId);
        });

        // 次月ボタン
        nextMonthBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const ym = this.dataset.ym;
            const roomTypeId = getSelectedRoomType();
            loadCalendar(ym, roomTypeId);
        });

        function loadCalendar(ym, roomTypeId) {
            showLoading();
            const planId = {{$plan->id}};
            
            fetch(`{{ route('user.calendar.data') }}?ym=${ym}&room_type_id=${roomTypeId}&plan_id=${planId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    calendarBody.innerHTML = data.weeks.join('');
                    roomTypeName.textContent =`部屋タイプ：${data.room_type_name}`;
                    // Format price with comma
                    const formattedPrice = new Intl.NumberFormat('ja-JP').format(data.price);
                    price.textContent = `料金：${formattedPrice}円〜`;
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

        function updateNavigation(ym) {
            const [year, month] = ym.split('-');
            const date = new Date(year, month - 1, 1);
            
            calendarTitle.textContent = `${year}年 ${parseInt(month)}月`;
            
            const prevDate = new Date(date);
            prevDate.setMonth(prevDate.getMonth() - 1);
            const prevYm = `${prevDate.getFullYear()}-${String(prevDate.getMonth() + 1).padStart(2, '0')}`;
            
            const nextDate = new Date(date);
            nextDate.setMonth(nextDate.getMonth() + 1);
            const nextYm = `${nextDate.getFullYear()}-${String(nextDate.getMonth() + 1).padStart(2, '0')}`;
            
            prevMonthBtn.dataset.ym = prevYm;
            nextMonthBtn.dataset.ym = nextYm;
        }

        function getSelectedRoomType() {
            return document.querySelector('input[name="room_type"]:checked').value;
        }
        
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

        function showLoading() {
            loadingOverlay.style.display = 'flex';
        }
        
        function hideLoading() {
            loadingOverlay.style.display = 'none';
        }
    });
</script>
@endsection