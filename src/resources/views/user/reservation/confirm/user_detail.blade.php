@extends('layouts.user-header')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-person-check me-2"></i>宿泊者情報の確認</h4>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('user.reservation.complete')}}" method="post">
                            @csrf
                            
                            <div class="alert alert-warning mb-4" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>内容をご確認の上、間違いがなければ「予約を確定する」ボタンを押してください。
                            </div>

                            <div class="list-group mb-5 shadow-sm">
                                <div class="list-group-item py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 fw-bold text-secondary">お名前</h5>
                                    </div>
                                    <p class="mb-1 fs-5">{{ session('lastname') }} {{ session('firstname') }} 様</p>
                                </div>
                                <div class="list-group-item py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 fw-bold text-secondary">メールアドレス</h5>
                                    </div>
                                    <p class="mb-1 fs-5">{{ session('email') }}</p>
                                </div>
                                <div class="list-group-item py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 fw-bold text-secondary">住所</h5>
                                    </div>
                                    <p class="mb-1 fs-5">{{ session('address') }}</p>
                                </div>
                                <div class="list-group-item py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 fw-bold text-secondary">電話番号</h5>
                                    </div>
                                    <p class="mb-1 fs-5">{{ session('tel') }}</p>
                                </div>
                                <div class="list-group-item py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 fw-bold text-secondary">ご意見、ご要望など</h5>
                                    </div>
                                    <p class="mb-1 fs-5 text-break">{!! nl2br(e(session('message'))) !!}</p>
                                </div>
                            </div>

                            <div class="d-flex gap-3 justify-content-center">
                                <a href="{{ route('user.top') }}" class="btn btn-outline-secondary btn-lg px-5">キャンセル</a>
                                <button type="submit" class="btn btn-danger btn-lg px-5 fw-bold">予約を確定する <i class="bi bi-check-circle ms-1"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

