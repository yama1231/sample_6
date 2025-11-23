<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="h4 font-weight-bold mb-0">{{ __('Profile') }}</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                ダッシュボードへ戻る
            </a>
        </div>
    </x-slot>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
