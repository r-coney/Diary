<?php

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

Route::prefix('/diaries')->name('diaryApp.')->namespace('App\Http\Controllers\DiaryApp')->group(function () {
    Route::name('diary.')->namespace('Diary')->group(function () {
        Route::get('/create', 'Create')->name('create');
        Route::post('/', 'Store')->name('store');
    });
});
