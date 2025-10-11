<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
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







// 管理者側

Route::prefix('admin')->group(function () {


    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


});
require __DIR__.'/auth.php';
