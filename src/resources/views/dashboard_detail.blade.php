<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2>お問合せ詳細</h2>
        </div>
    </x-slot>
    <div class="container-fluid px-3 py-4">
    <div class="min-h-screen bg-gray-100">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>件名</th>
                    <th>氏名</th>
                    <th>メールアドレス</th>
                    <th>内容</th>
                    <th>お問合せ日</th>
                    <th>対応状況</th>
                </tr>
            </thead>
            <tbody>
            
                <tr>
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->title }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->detail }}</td>
                    <td>{{ $contact->created_at }}</td>
                    @if ($contact->status == 0)
                        <td>未対応</td>
                    @elseif ($contact->status == 1)
                        <td>対応中</td>
                    @elseif ($contact->status == 2)
                        <td>対応済み</td>
                    @endif
                    
                    {{-- <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            詳細
                        </button>
                    </td> --}}
                </tr>

                <!-- モーダル本体 -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <form action="{{ route('dashboard_edit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">
                                        変更しない
                                    </button>
                                    <button type="submit" name="status" value="0" class="btn btn-primary">
                                        未対応
                                    </button>
                                    <button type="submit" name="status" value="1" class="btn btn-primary">
                                        対応中
                                    </button>
                                    <button type="submit" name="status" value="2" class="btn btn-primary">
                                        完了
                                    </button>
                                </form> 
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </tbody>
        </table>
        <div class="d-flex justify-content-end align-items-center py-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                ステータス変更
            </button>
        </div>
        <p>たて箇条書き、ステータス記載、ボタンを下に設置、ステータス変更後に詳細画面に再遷移</p>
        <p>ステータス変更後にセッションメッセージを表示</p>
        <div class="m-4">
            <a href="{{ route('dashboard') }}" class="hidden space-x-8 sm:-my-px sm:flex sm:items-center font-medium text-xl text-gray-900 hover:text-gray-700 transition">
                ダッシュボードへ戻る
            </a>
        </div>
    </div>
    </div>
</x-app-layout>