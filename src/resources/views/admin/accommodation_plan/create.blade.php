<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">宿泊プラン作成</h2>
    </x-slot>
    <div class="container py-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('accommodation-plans.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="price" class="form-label">プラン名 <span class="text-danger">*</span></label>
                        <input type="text" 
                                class="form-control @error('title') is-invalid @enderror" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}" 
                                required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">価格 <span class="text-danger">*</span></label>
                        <input type="number" 
                                class="form-control @error('price') is-invalid @enderror" 
                                id="price" 
                                name="price" 
                                value="{{ old('price') }}" 
                                required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">説明 <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                    id="description" 
                                    name="description" 
                                    rows="5" 
                                    required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_slot_id" class="form-label">予約枠ID</label>
                        <select
                            class="form-select"
                            id="reservation_slot_id"
                            name="reservation_slot_id"
                            size="10"
                            style="overflow-y:auto height:200px"
                            required
                        >
                        <option value="">-- 予約枠を選択してください --</option>
                        @foreach($reservationSlots as $slot)
                            <option value="{{$slot->id}}" {{old('reservation_slot_id') == $slot->id ? 'selected' :''}}>
                            {{-- 確認用{{$slot->id}}: {{$slot->reservation_date}} --- {{$slot->roomType->name}} --}}
                                {{$slot->reservation_date}} --- {{$slot->roomType->name}}
                            </option>
                        @endforeach
                        @error('reservation_slot_id')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">画像（複数選択可）</label>
                        <input type="file" 
                                class="form-control @error('images.*') is-invalid @enderror" 
                                id="images" 
                                name="images[]" 
                                multiple 
                                accept="image/*">
                        @error('images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">JPEG, PNG, GIF形式（最大2MB）</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">作成</button>
                        <a href="{{ route('accommodation-plans.index') }}" class="btn btn-secondary">キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>