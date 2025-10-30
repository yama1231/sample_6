<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">備考欄（管理者記載）(仮)</h2>
    </x-slot>

            <form action="{{ route('reservation.memo_save') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="admin_memo" class="form-label h5">備考欄（管理者記載）</label>
                    <textarea class="form-control" 
                        id="admin_memo" 
                        name="admin_memo" 
                        rows="5"
                        >{{ $reservation->admin_memo === null ? '特になし' : $reservation->admin_memo}}</textarea>
                        <input type="hidden" name="reservation_id" value="{{$reservation->id}}">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">保存</button>
                    {{-- <a href="{{ route('reservation.show', $id) }}" class="btn btn-secondary">詳細へ戻る</a> --}}
                    <a href="{{ route('reservation.index') }}" class="btn btn-secondary">一覧へ戻る</a>
                </div>
            </form>
            
</x-app-layout>