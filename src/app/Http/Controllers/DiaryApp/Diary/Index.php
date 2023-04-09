<?php

namespace App\Http\Controllers\DiaryApp\Diary;

use App\DiaryApp\UseCase\Diary\GetList\GetListCommand;
use App\DiaryApp\UseCase\Diary\GetList\GetListInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Index extends Controller
{
    private GetListInterface $getList;

    public function __construct(GetListInterface $getList)
    {
        $this->getList = $getList;
    }

    public function __invoke(Request $request)
    {
        $diaryListData = ($this->getList)(
            new GetListCommand(
                Auth::id(),
                config('DiaryApp.constants.diaryListPerPage'),
                $request->query('page', 1),
            )
        );

        return view('diary_app.diary.index', ['diaryList' => $diaryListData->diaryList()]);
    }
}
