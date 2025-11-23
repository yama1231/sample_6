<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\AccommodationPlanController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationSlotController;
use App\Models\AccommodationPlan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\UserReservationController;

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
})->name('user.top');

// Route::get('/top', function () {
//     return redirect('/');
// })->name('user.top');
// アクセス
Route::get('/access', [AccessController::class, 'access'])->name('user.access');
// お問い合わせ
Route::get('/contact/index', [ContactController::class, 'index'])->name('user.contact.index');
Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('user.contact.confirm');
Route::post('/contact/complete', [ContactController::class, 'complete'])->name('user.contact.complete');
//宿泊プラン index search show callendar
Route::get('/accommodation-plans/top', [AccommodationPlanController::class, 'top'])->name('user.accommodation-plan.top');
Route::get('/accommodation-plans/search', [AccommodationPlanController::class, 'search'])->name('user.accommodation-plan.search');
Route::get('/accommodation-plans/detail', [AccommodationPlanController::class, 'detail'])->name('user.accommodation-plan.detail');
// Route::get('/accommodation-plans/callendar', [AccommodationPlanController::class, 'callendar'])->name('user.accommodation-plan.callendar');
//callendar
Route::get('/accommodation-plans/calendar', [CalendarController::class, 'index'])->name('user.calendar');
// Ajax用
Route::get('/accommodation-plans/calendar/data',[CalendarController::class, 'getCalendarData'])->name('user.calendar.data');
// 予約
Route::get('/reservation/create', [UserReservationController::class, 'create'])->name('user.reservation.create');
Route::post('/reservation/confirm/plan', [UserReservationController::class, 'confirmPlan'])->name('user.reservation.confirmPlan');
Route::get('/reservation/confirm/user_detail', [UserReservationController::class, 'confirmUser'])->name('user.reservation.confirmUser');
Route::post('/reservation/complete', [UserReservationController::class, 'complete'])->name('user.reservation.complete');


// 管理者側
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
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
        // 宿泊プラン
        Route::resource('accommodation-plans', AccommodationPlanController::class);
        // 予約
        Route::get('/reservation/index', [AdminReservationController::class, 'index'])->name('reservation.index');
        Route::get('/reservation/confirm/show/{reservation}', [AdminReservationController::class, 'show'])->name('reservation.show');
        Route::get('/reservation/confirm/memo/{reservation}', [AdminReservationController::class, 'memo'])->name('reservation.memo');
        Route::post('/reservation/memo_save', [AdminReservationController::class, 'memo_save'])->name('reservation.memo_save');
        Route::post('/reservation/cancel', [AdminReservationController::class, 'cancel'])->name('reservation.cancel');
        Route::get('/reservation/search', [AdminReservationController::class, 'search'])->name('reservation.search');

    });
});
require __DIR__.'/auth.php';
