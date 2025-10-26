@extends('layouts.user-header')
@section('content')

    <div class="container-fluid p-4">
        <div class='d-flex justify-content-end mb-3'>
            <div class="gap-3">
                <form action="{{route('user.accommodation-plan.search')}}" class="search-form-6">
                    <div class="d-flex gap-2 align-items-center">
                        <input type="text" class="form-control" placeholder="検索欄" id="keyword" name="keyword" >
                        <button type="submit" aria-label="検索" class="btn btn-success text-nowrap">検索</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            @forelse ($plans as $plan)

            {{-- 画像をcard-topの中で中央揃え、タイトルと説明文の高さは固定にするーただレスポンシブは対応 --}}

                <div class="col">
                    <div class="card text-center h-100">
                        @if($plan->images->first())
                        <img src="{{ asset('storage/' . $plan->images->first()->image_path) }}" 
                            class="card-img-top" 
                            alt="{{ $plan->title }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" 
                                class="card-img-top" 
                                alt="No Image">
                        @endif                       
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{$plan->title}}</h5>
                            <p class="card-text">{{$plan->description}}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            {{-- <li class="list-group-item">料金：{{number_format($plan->price)}} 円</li> --}}
                            <li class="list-group-item">
                                <a href="{{ route('user.accommodation-plan.detail', ['plan_id' => $plan]) }}" class="btn btn-primary">
                                    詳細
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">宿泊プランがありません。</div>
                </div>
            @endforelse
            
        </div>
    </div>
@endsection