<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div>
        {{ __("You're logged in!") }}
    </div>
    <br>
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
                    <th>ステータス変更</th>
                    <th>詳細</th>
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
                                <button type="submit">
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
{{-- {!! $contact_list->render() !!} --}}
{!! $contact_list->links('pagination::bootstrap-5') !!}
    <br>
    <br>

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

        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            Profile
        </a>
        <a href="{{ route('reservation_slots.index') }}" class="btn btn-primary">
            予約枠
        </a>
    {{-- </form> --}}
    <br>
    <form action="{{ route('logout') }}" method="POST" id="logout-form">
        @csrf
        <button type="submit">
            Logout
        </button>
    </form> 
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
