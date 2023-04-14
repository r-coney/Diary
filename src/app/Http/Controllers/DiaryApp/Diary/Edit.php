<?php

namespace App\Http\Controllers\DiaryApp\Diary;

use App\Http\Controllers\Controller;
use App\DiaryApp\UseCase\Diary\GetDetail\GetDetailInterface;
use Domain\DiaryApp\Models\Diary\Id;

class Edit extends Controller
{
    private GetDetailInterface $getDetail;

    public function __construct(GetDetailInterface $getDetail)
    {
        $this->getDetail = $getDetail;
    }

    public function __invoke($id)
    {
        $diaryData = ($this->getDetail)(new Id($id));

        return view('diary_app.diary.edit', ['diaryData' => $diaryData]);
    }
}
