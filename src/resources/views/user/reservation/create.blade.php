@extends('layouts.user-header')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>ご予約情報入力</h4>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('user.reservation.confirmPlan')}}" method="post">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="lastname" class="form-label fw-bold">氏名 (Last Name) <span class="badge bg-danger ms-1">必須</span></label>
                                <input 
                                    type="text" 
                                    name="lastname" 
                                    class="form-control form-control-lg" 
                                    id="lastname"
                                    placeholder="例：山田"
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label for="firstname" class="form-label fw-bold">名前 (First Name) <span class="badge bg-danger ms-1">必須</span></label>
                                <input 
                                    type="text" 
                                    name="firstname" 
                                    class="form-control form-control-lg" 
                                    id="firstname"
                                    placeholder="例：太郎"
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">メールアドレス <span class="badge bg-danger ms-1">必須</span></label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    class="form-control form-control-lg" 
                                    id="email"
                                    placeholder="例：yamada@example.com"
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label for="address" class="form-label fw-bold">住所 <span class="badge bg-danger ms-1">必須</span></label>
                                <input 
                                    type="text" 
                                    name="address" 
                                    class="form-control form-control-lg" 
                                    id="address"
                                    placeholder="例：東京都渋谷区..."
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label for="tel" class="form-label fw-bold">電話番号 <span class="badge bg-danger ms-1">必須</span></label>
                                <input 
                                    type="tel" 
                                    name="tel" 
                                    class="form-control form-control-lg" 
                                    id="tel"
                                    placeholder="例：090-1234-5678"
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label fw-bold">ご意見、ご要望など</label>
                                <textarea 
                                    class="form-control" 
                                    name="message" 
                                    id="message" 
                                    rows="4"
                                    placeholder="その他、ご要望がございましたらご記入ください。"
                                ></textarea>
                            </div>

                            <div class="d-flex gap-3 justify-content-center mt-5">
                                <a href="{{ route('user.top') }}" class="btn btn-outline-secondary btn-lg px-5">キャンセル</a>
                                <button type="submit" class="btn btn-primary btn-lg px-5">次へ進む <i class="bi bi-chevron-right ms-1"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

