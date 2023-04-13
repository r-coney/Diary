<?php

namespace App\Http\Controllers\DiaryApp\Diary;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Domain\DiaryApp\Models\Diary\Id;
use App\DiaryApp\UseCase\Diary\GetDetail\GetDetailInterface;

class Detail extends Controller
{
    private GetDetailInterface $getDetail;

    public function __construct(GetDetailInterface $getDetail)
    {
        $this->getDetail = $getDetail;
    }

    public function __invoke(int $id)
    {
        $diaryData = ($this->getDetail)(new Id($id));

        return view('diary_app.diary.detail', [
            'diaryData' => $diaryData,
        ]);
    }
}
