<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">宿泊プラン編集</h2>
    </x-slot>
    <div class="container py-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('accommodation-plans.update', $accommodationPlan) }}" 
                        method="POST" 
                        enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="price" class="form-label">プラン名 <span class="text-danger">*</span></label>
                        <input type="text" 
                                class="form-control @error('title') is-invalid @enderror" 
                                id="title" 
                                name="title" 
                                value="{{ old('title', $accommodationPlan->title) }}" 
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
                                value="{{ old('price', $accommodationPlan->price) }}" 
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
                                    required>{{ old('description', $accommodationPlan->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_slot_id" class="form-label">予約枠ID：</label>
                        <h5>{{$accommodationPlan->reservationSlot->id}}</h5>
                        {{-- <input type="number" 
                                class="form-control @error('room_slot_id') is-invalid @enderror" 
                                id="room_slot_id" 
                                name="room_slot_id" 
                                value="{{ old('room_slot_id', $accommodationPlan->id) }}"> --}}
                        {{-- <p>{{$accommodationPlan->id}}</p> --}}
                        {{-- @error('room_slot_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror --}}
                    </div>

                    <!-- 既存画像表示 -->
                    @if ($accommodationPlan->images->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">現在の画像</label>
                            <div class="row">
                                @foreach ($accommodationPlan->images as $image)
                                    <div class="col-md-3 mb-2">
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                    class="card-img-top" 
                                                    style="height: 150px; object-fit: cover;">
                                            <div class="card-body p-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" 
                                                            type="checkbox" 
                                                            name="delete_images[]" 
                                                            value="{{ $image->id }}" 
                                                            id="delete_{{ $image->id }}">
                                                    <label class="form-check-label" for="delete_{{ $image->id }}">
                                                        削除
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="images" class="form-label">画像を追加（複数選択可）</label>
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
                        <button type="submit" class="btn btn-primary">更新</button>
                        <a href="{{ route('accommodation-plans.index') }}" class="btn btn-secondary">キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    // 画像選択を複数のフォームで選択できるようにする（時間があるときに）。追加ボタンを設置してフォームを増やせるようにする
</script>        
