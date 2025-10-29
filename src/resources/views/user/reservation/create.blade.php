@extends('layouts.user-header')
@section('content')
    <div class="min-h-screen bg-gray-100">
        <form action="{{ route('user.reservation.confirmPlan')}}" method="post">
            @csrf
            <br>
            <h4>ご予約情報：</h4>
            <br>
            <div class="mb-3">
                <label for="lastname" class="form-label">氏名(lastname)<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="lastname" 
                    class="form-control" 
                    id="lastname"
                >
            </div>
            <div class="mb-3">
                <label for="firstname" class="form-label">名前(firstname)<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="firstname" 
                    class="form-control" 
                    id="firstname"
                >
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="email" 
                    class="form-control" 
                    id="email"
                >
                {{-- type="email"  --}}
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">住所<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="address" 
                    class="form-control" 
                    id="address"
                >
            </div>
            <div class="mb-3">
                <label for="tel" class="form-label">電話番号<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="tel" 
                    class="form-control" 
                    id="tel"
                >
                </textarea>
                {{-- type="tel"かナンバー形  --}}
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">ご意見、ご要望など</label>
                <textarea 
                    class="form-control" 
                    name="message" 
                    id="message" 
                    rows="3"
                >
                </textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">次へ</button>
                <a href="{{ route('user.top') }}" class="btn btn-secondary">キャンセル</a>
            </div>
        </form>

    </div>
@endsection

