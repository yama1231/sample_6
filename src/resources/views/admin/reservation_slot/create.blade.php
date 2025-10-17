<x-app-layout>
<x-slot name="header">
    <h2 class="h4 mb-0">予約枠作成</h2>
</x-slot>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('reservation_slots.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="reservation_date" class="form-label">予約日</label>
                            <input type="date" 
                                    class="form-control @error('reservation_date') is-invalid @enderror" 
                                    id="reservation_date" 
                                    name="reservation_date" 
                                    value="{{ old('reservation_date') }}" 
                                    required>
                            @error('reservation_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="room_type_id" class="form-label">部屋タイプ</label>
                            <select class="form-select @error('room_type_id') is-invalid @enderror" 
                                    id="room_type_id" 
                                    name="room_type_id" 
                                    required>
                                <option value="">選択してください</option>
                                @foreach ($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}" 
                                            {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>
                                        {{ $roomType->name }}（基本部屋数: {{ $roomType->base_room_count }}）
                                    </option>
                                @endforeach
                            </select>
                            @error('room_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">作成</button>
                            <a href="{{ route('reservation_slots.index') }}" class="btn btn-secondary">
                                キャンセル
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>