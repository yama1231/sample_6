<x-app-layout>
<x-slot name="header">
    <div class="d-flex justify-content-between align-items-center py-3">
        <h2 class="h4 mb-0">予約枠一覧</h2>
        <a href="{{ route('reservation_slots.create') }}" class="btn btn-primary">
            新規作成
        </a>
    </div>
</x-slot>

<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>対象日</th>
                            <th>部屋タイプ</th>
                            <th>利用可能数</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservationSlots as $slot)
                            <tr>
                                <td>{{ $slot->reservation_date->format('Y年m月d日') }}</td>
                                <td>{{ $slot->roomType->name }}</td>
                                <td>{{ $slot->available_rooms }}</td>
                                <td>
                                    <a href="{{ route('reservation_slots.edit', $slot) }}" 
                                        class="btn btn-sm btn-outline-primary">
                                        編集
                                    </a>
                                    <form action="{{ route('reservation_slots.destroy', $slot) }}" 
                                            method="POST" 
                                            class="d-inline"
                                            onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            削除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    予約枠がありません
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mb-4 my-4">
                {!! $reservationSlots->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
</x-app-layout>