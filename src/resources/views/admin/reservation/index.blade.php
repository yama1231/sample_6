<x-app-layout>
<x-slot name="header">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="h4 mb-0">予約一覧</h2>
    </div>
</x-slot>

<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class='d-flex justify-content-end mb-3'>
            <div class="gap-3">
                <form action="{{route('reservation.search')}}" class="search-form-6">
                    <div class="d-flex gap-2 align-items-center">
                        <input type="text" class="form-control" placeholder="検索欄" id="keyword" name="keyword" >
                        <button type="submit" aria-label="検索" class="btn btn-success text-nowrap">検索</button>
                    </div>
                </form>
            </div>
        </div>
{{-- delete_flagが１のものは、予約キャンセルのステータス表示をする。あと詳細画面の予約キャンセルボタンを非表示にする--}}

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>宿泊プラン</th>
                            <th>部屋タイプ</th>
                            <th>予約日</th>
                            <th>名前</th>
                            <th>受付日時</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- ->format('Y年m月d日') --}}
                        @forelse ($reservationList as $reservation)
                            <tr>
                                <td>{{ $reservation->plan_name }}</td>
                                <td>{{ $reservation->room_type_name }}</td>
                                <td>{{ $reservation->reservation_date->format('Y年m月d日') }}</td>
                                <td>{{ $reservation->lastname }}&nbsp;{{ $reservation->firstname }}</td>
                                <td>{{ $reservation->created_at->format('Y年m月d日') }}</td>
                                <td>
                                    <a href="{{ route('reservation.show', $reservation) }}" 
                                        class="btn btn-sm btn-outline-primary">
                                        詳細
                                    </a>
                                    {{-- <form action="{{ route('reservation_reservations.destroy', $reservation) }}" 
                                            method="POST" 
                                            class="d-inline"
                                            onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            削除
                                        </button>
                                    </form> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    予約枠がありません
                                </td>
                                {{-- マイグレ後か予約削除時に確認 --}}
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $reservationList->links() }}
            </div>
        </div>
    </div>
    <br>
    <a href="{{ route('dashboard') }}">
        ダッシュボードへ戻る
    </a>
</div>
</x-app-layout>