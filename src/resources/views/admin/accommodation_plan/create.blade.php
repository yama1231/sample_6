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
                        <label for="price" class="form-label">価格 <span class="text-danger">*</span></label>
                        @foreach($roomTypes as $roomType)
                            <p>{{$roomType->name}}の部屋：</p>
                            <input type="number" 
                                    class="form-control @error('price') is-invalid @enderror" 
                                    id="price_{{$roomType->id}}" 
                                    name="prices[{{$roomType->id}}]" 
                                    value="{{ old('price'.$roomType->id) }}" 
                                    required>
                            <input type="hidden" name="roomtype[{{$roomType->id}}]" value="{{$roomType->id}}">
                            @error('price'.$roomType->id)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        @endforeach
                        
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
<input type="file" id="test" multiple accept="image/*">
    <script>
        document.getElementById('test').addEventListener('change', function() {
            console.log('File selected:', this.files);
            alert('ファイルが選択されました: ' + this.files.length + '個');
        });
    </script>