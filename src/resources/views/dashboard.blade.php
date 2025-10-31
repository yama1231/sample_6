<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2>{{ __('Dashboard') }}</h2>
            <a href="{{ route('register') }}" class="ms-4 text-decoration-underline">管理ユーザ-登録</a>
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
                    {{-- <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            詳細
                        </button>
                    </td> --}}
                </tr>

                <!-- モーダル本体 -->
                {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $contact->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                対応ステータスの変更が可能です。
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">変更しない</button>
                                <button type="button" class="btn btn-primary">対応中</button>
                                <button type="button" class="btn btn-primary">変更</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div> --}}



            @endforeach
            </tbody>
        </table>
        </div>
        </div>
        </div>
    </div>
{{-- {!! $contact_list->render() !!} --}}
{!! $contact_list->links('pagination::bootstrap-5') !!}


    {{-- <x-slot name="content">
        <x-dropdown-link :href="route('profile.edit')">
            {{ __('Profile') }}
        </x-dropdown-link>

        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-dropdown-link>
        </form>
    </x-slot> --}}



    {{-- <form method="GET" action="{{ route('profile.edit') }}"> --}}
        {{-- <button type="submit" href="{{ route('profile.edit') }}">
            Profile
        </button> --}}

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
    {{-- </form> --}}
    <br>
    
</x-app-layout>



{{-- @extends('layouts.user')
@section('content')
    <h3>お問合せ一覧</h3>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>件名</th>
                    <th>氏名</th>
                    <th>お問合せ日</th>
                    <th>対応状況</th>
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
                        <td>対応済み</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
{!! $contact_list->links('pagination::bootstrap-5') !!}


    <div class="modal-dialog modal-dialog-centered">
    ...
    </div>


    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    ...
    </div>
    <br>
    <form method="POST" action="{{ route('logout') }}" id="logout-form">
        @csrf
        <button type="submit">
            Logout
        </button>
    </form> 
@endsection --}}
