<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

// お問い合わせフォーム
Route::get('/', [ContactController::class, 'index'])->name('contact.index');
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/thanks', [ContactController::class, 'store']);

// ログインフォーム表示
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// ログイン処理
Route::post('/login', [AuthController::class, 'login']);
// ログアウト処理
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// 会員登録画面表示
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
// 会員登録処理
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::middleware('auth')->group(function () {
    // 管理画面（検索・ページネーション
    Route::get('/admin', [AuthController::class, 'index'])->name('admin.contacts.index');
    // CSVエクスポート
    Route::get('/admin/export', [AuthController::class, 'export'])->name('admin.contacts.export');
    Route::delete('/contacts/{id}', [AuthController::class, 'destroy'])->name('admin.contacts.destroy');
});
