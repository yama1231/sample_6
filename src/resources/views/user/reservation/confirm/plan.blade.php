@extends('layouts.user-header')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-clipboard-check me-2"></i>ご予約内容の確認</h4>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('user.reservation.confirmUser')}}" method="GET">
                            
                            <div class="alert alert-info mb-4" role="alert">
                                <i class="bi bi-info-circle me-2"></i>以下の内容で予約を進めます。よろしければ「次へ」ボタンを押してください。
                            </div>

                            <div class="list-group mb-5 shadow-sm">
                                <div class="list-group-item py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 fw-bold text-secondary">宿泊プラン</h5>
                                    </div>
                                    <p class="mb-1 fs-5">{{ session('plan_name') }}</p>
                                </div>
                                <div class="list-group-item py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 fw-bold text-secondary">部屋タイプ</h5>
                                    </div>
                                    <p class="mb-1 fs-5">{{ session('room_type_name') }}</p>
                                </div>
                                <div class="list-group-item py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 fw-bold text-secondary">料金</h5>
                                    </div>
                                    <p class="mb-1 fs-4 fw-bold text-primary">{{ number_format(session('price')) }}円</p>
                                </div>
                            </div>

                            <div class="d-flex gap-3 justify-content-center">
                                <a href="{{ route('user.top') }}" class="btn btn-outline-secondary btn-lg px-5">キャンセル</a>
                                <button type="submit" class="btn btn-primary btn-lg px-5">次へ <i class="bi bi-chevron-right ms-1"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

