<?php

namespace App\Http\Controllers\DiaryApp\Diary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Create extends Controller
{
    public function __invoke()
    {
        return view('diary_app.diary.create');
    }
}
