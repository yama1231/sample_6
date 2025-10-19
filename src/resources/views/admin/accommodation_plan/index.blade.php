<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">宿泊プラン一覧</h2>
    </x-slot>
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('accommodation-plans.create') }}" class="btn btn-primary">
                新規作成
            </a>
        </div>

        <div class="row">
            @forelse ($plans as $plan)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        @if ($plan->images->first())
                            <img src="{{ asset('storage/' . $plan->images->first()->image_path) }}" 
                                    class="card-img-top" 
                                    style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                    style="height: 200px;">
                                画像なし
                            </div>
                        @endif
                        {{-- 宿泊プラン：タイトル、金額、説明 --}}
                        <div class="card-body">
                            <h5 class="card-title">{{ $plan->title }}</h5>
                            <p class="card-text">{{ number_format($plan->price) }}円</p>
                            <p class="card-text">{{ Str::limit($plan->description, 100) }}</p>
                        </div>
                        
                        <div class="card-footer bg-white">
                            <div class="d-flex gap-2">
                                <a href="{{ route('accommodation-plans.show', $plan) }}" 
                                {{--  <a href="{{ route('accommodation_plans.show', $plan) }}" は間違い。ハイフン！！--}}
                                    class="btn btn-sm btn-info text-white">詳細</a>
                                <a href="{{ route('accommodation-plans.edit', $plan) }}" 
                                    class="btn btn-sm btn-warning">編集</a>
                                <form action="{{ route('accommodation-plans.destroy', $plan) }}" 
                                        method="POST" 
                                        onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">削除</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">宿泊プランがありません。</div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $plans->links() }}
        </div>
    </div>
</x-app-layout>