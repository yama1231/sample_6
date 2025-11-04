<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2>{{ __('Dashboard') }}</h2>
            <a href="{{ route('register') }}" class="ms-4 text-decoration-underline">管理ユーザー登録</a>
        </div>
        <div class="d-flex justify-content-end align-items-center pb-3">
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary">
                ログアウト
            </button>
        </form> 
        </div>
    </x-slot>
    <br>
    <h3 class="ms-3">お問合せ一覧</h3>
    <div class="container-fluid px-3 py-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>件名</th>
                                <th>氏名</th>
                                <th>お問合せ日</th>
                                <th>対応状況</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contact_list as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>{{ $contact->title }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->created_at }}</td>
                                    @if ($contact->status == 0)
                                        <td>未対応</td>
                                    @elseif ($contact->status == 1)
                                        <td>対応中</td>
                                    @elseif ($contact->status == 2)
                                        <td>対応済み</td>
                                    @endif
                                    <td>
                                        <form action="{{ route('dashboard_detail') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    詳細
                                                </button>
                                        </form> 
                                    </td> 
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div >
        <div class="m-3">
            {!! $contact_list->links('pagination::bootstrap-5') !!}
        </div >
    </div>
    <div class="d-flex justify-content-start align-items-center py-3 ms-3">
        <a href="{{ route('profile.edit') }}" class="btn btn-primary mx-1">
            プロフィール
        </a>
        <a href="{{ route('reservation_slots.index') }}" class="btn btn-primary mx-1">
            予約枠
        </a>
        <a href="{{ route('accommodation-plans.index') }}" class="btn btn-primary mx-1">
            宿泊プラン
        </a>
        <a href="{{ route('reservation.index') }}" class="btn btn-primary mx-1">
            予約一覧
        </a>
    </div>
    <br>
</x-app-layout>