<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">宿泊プラン詳細</h2>
    </x-slot>

    <div class="container py-4">
        <div class="card">
            <div class="card-body">
                <!-- 画像カルーセル -->
                @if ($accommodationPlan->images->count() > 0)
                    <div id="planImagesCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($accommodationPlan->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                        class="d-block w-100" 
                                        style="height: 400px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        @if ($accommodationPlan->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#planImagesCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#planImagesCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                @endif

                <h3 class="mb-3">{{ $accommodationPlan->title }}</h3>
                
                <div class="mb-3">
                    <h5>設定料金：</h5>
                    @foreach($accommodationPlan->prices as $price)
                        <p>{{$price->room_type}}{{ number_format($price->price) }}円</p>
                        <p>{{$price->roomType->name}}</p>
                        
                    @endforeach
                    <h5>説明：</h5>
                    <p>{{ $accommodationPlan->description }}</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('accommodation-plans.edit', $accommodationPlan) }}" class="btn btn-warning">編集</a>
                    <a href="{{ route('accommodation-plans.index') }}" class="btn btn-secondary">一覧へ戻る</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>