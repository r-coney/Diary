<?php

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

require __DIR__.'/auth.php';

// DiaryApp
Route::prefix('/')->name('diaryApp.')->namespace('App\Http\Controllers\DiaryApp')->group(function () {
    Route::prefix('diary')->name('diary.')->namespace('Diary')->group(function () {
        Route::get('/create', 'Create')->name('create');
        Route::post('/', 'Store')->name('store');
        Route::get('/', 'Index')->name('index');
        Route::get('/{id}', 'Detail')->name('detail');
        Route::get('/{id}/edit', 'Edit')->name('edit');
        Route::put('/{id}', 'Update')->name('update');
        Route::delete('/{id}', 'Delete')->name('delete');
    });
});

// UserAccount
Route::prefix('/')->name('userAccount.')->namespace('App\Http\Controllers\UserAccount')->group(function () {
    Route::prefix('user')->name('user.')->namespace('User')->group(function () {
        Route::get('/register', 'Register')->name('register');
        Route::post('/', 'Store')->name('store');
        Route::get('/{id}','Detail')->name('detail');
    });
});