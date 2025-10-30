<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">予約詳細</h2>
    </x-slot>

    <div class="container py-4">
        <div class="card">
            <div class="card-body">
                <!-- 画像カルーセル -->
                {{-- @if ($reservation->images->count() > 0)
                    <div id="planImagesCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($reservation->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                        class="d-block w-100" 
                                        style="height: 400px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        @if ($reservation->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#planImagesCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#planImagesCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                @endif --}}

                <h3 class="mb-3">{{ $reservation->title }}</h3>
                
                <div class="mb-3">
                    <h5>宿泊プラン：{{ $reservation->plan_name }}</h5>
                    <h5>部屋タイプ：{{ $reservation->room_type_name }}</h5>
                    <h5>料金：{{ $reservation->price }}</h5>
                    <h5>氏名(lastname)： {{ $reservation->lastname }}</h5>
                    <h5>名前(firstname)： {{ $reservation->firstname }}</h5>
                    <h5>メールアドレス：{{ $reservation->email }}</h5>
                    <h5>住所：{{ $reservation->address }}</h5>
                    <h5>電話番号：{{ $reservation->tel }}</h5>
                    <h5>ご要望など：{{ $reservation->user_message === null ? '特になし' : $reservation->user_message }}</h5>
                    <h5>備考欄（管理者記載）：{{ $reservation->admin_memo === null ? '特になし' : $reservation->admin_memo}} &nbsp; <a href="{{ route('reservation.memo', $reservation) }}" class="btn btn-warning">編集</a></h5>
                </div>

                <div class="d-flex gap-2">
                    
                    <form action="{{ route('reservation.cancel') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                    {{-- <a href="{{ route('reservation.cancel') }}" class="btn btn btn-danger">予約キャンセル</a> --}}
                        <button type="submit" class="btn btn btn-danger">予約キャンセル</button>
                    </form>
                    <a href="{{ route('reservation.index') }}" class="btn btn-secondary">一覧へ戻る</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>