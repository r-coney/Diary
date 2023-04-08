<?php

namespace App\Http\Controllers\DiaryApp\Diary;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DiaryApp\UseCase\Diary\Create\CreateCommand;
use App\DiaryApp\UseCase\Diary\Create\CreateInterface;

class Store extends Controller
{
    private $createDiary;

    public function __construct(
        CreateInterface $createDiary
    ) {
        $this->createDiary = $createDiary;
    }

    public function __invoke(Request $request)
    {
        $userId = 1;
        $createCommand = new CreateCommand(
            $userId,
            $request->input('title'),
            $request->input('content'),
            $request->input('mainCategoryId'),
            $request->input('subCategoryId'),
        );

        ($this->createDiary)($createCommand);

        return redirect()->route('diaryApp.diary.index');
    }
}
