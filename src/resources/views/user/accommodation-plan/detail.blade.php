@extends('layouts.user-header')
@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-body">
                    <div class="mb-3">
                        <div class="fs-4 fw-bold">プラン名：</div>
                        <div class="fs-4">{{ $plan->title }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="fs-4 fw-bold">価格</div>
                        @foreach($plan->prices as $price)
                            <div>
                                <p>部屋タイプ：{{$price->roomType->name}}</p>
                            <div>
                            <div>
                                <p>料金：{{$price->price}}円</p>
                            <div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <div class="form-label">説明：</div>
                        {{$plan->description}}
                    </div>

                    <!-- 既存画像表示    index同様、画像のサイズを調整する-->
                    @if ($plan->images->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">現在の画像</label>
                            <div class="row">
                                @foreach ($plan->images as $image)
                                    <div class="col-md-3 mb-2">
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                    class="card-img-top" 
                                                    style="height: 150px; object-fit: cover;">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.calendar') }}" class="btn btn-primary">予約する</a>
                        <a href="{{ route('user.accommodation-plan.top') }}" class="btn btn-secondary">キャンセル</a>
                    </div>
            </div>
        </div>
    </div>
@endsection