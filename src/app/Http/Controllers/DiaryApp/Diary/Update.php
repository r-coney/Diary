<?php

namespace App\Http\Controllers\DiaryApp\Diary;

use App\DiaryApp\UseCase\Diary\Edit\EditCommand;
use App\DiaryApp\UseCase\Diary\Edit\EditInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Update extends Controller
{
    private EditInterface $editDiary;

    public function __construct(EditInterface $editDiary)
    {
        $this->editDiary = $editDiary;
    }

    public function __invoke(Request $request, int $id)
    {
        ($this->editDiary)(
            new EditCommand(
                $id,
                $request->input('title'),
                $request->input('content'),
                $request->input('mainCategoryId'),
                $request->input('subCategoryId'),
            )
        );

        return redirect()->route('diaryApp.diary.detail', ['id' => $id]);
    }
}
