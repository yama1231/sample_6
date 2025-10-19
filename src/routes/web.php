<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\AccommodationPlanController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationSlotController;
use App\Models\AccommodationPlan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// ユーザー側

// ホーム画面
Route::get('/', function () {
    return view('user.top');
});
Route::get('/top', function () {
    return redirect('/');
})->name('user.top');
// アクセス
Route::get('/access', [AccessController::class, 'access'])->name('user.access');
// お問い合わせ
Route::get('/contact/index', [ContactController::class, 'index'])->name('user.contact.index');
Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('user.contact.confirm');
Route::post('/contact/complete', [ContactController::class, 'complete'])->name('user.contact.complete');
//宿泊プラン index search show
Route::resource('/accommodation-plans', AccommodationPlanController::class);
Route::get('/accommodation-plans/top', [ContactController::class, 'top'])->name('user.plan.top');
Route::get('/accommodation-plans/search', [ContactController::class, 'search'])->name('user.accommodation-plans.search');
Route::get('/accommodation-plans/detail', [ContactController::class, 'detail'])->name('user.accommodation-plans.detail');



// 管理者側
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    //管理者側　ログイン後画面（後で最初にログイン画面が来るように修正する）
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->middleware(['auth', 'verified'])->name('dashboard');

    // ダッシュボード
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    });

    Route::middleware('auth')->group(function () {
        // プロフィール
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        // お問い合わせ　　　🌟dashboard.detailなど統一する🌟
        Route::get('/dashboard/detail', [HomeController::class, 'dashboard_detail'])->name('dashboard_detail');
        Route::post('/dashboard/detail', [HomeController::class, 'dashboard_detail'])->name('dashboard_detail');
        Route::post('/dashboard/edit', [HomeController::class, 'dashboard_edit'])->name('dashboard_edit');
        // 予約枠
        Route::resource('/reservation_slots', ReservationSlotController::class);
    });
});
require __DIR__.'/auth.php';
