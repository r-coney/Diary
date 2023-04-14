<?php

namespace App\Http\Controllers\DiaryApp\Diary;

use App\Http\Controllers\Controller;
use App\DiaryApp\UseCase\Diary\Delete\DeleteInterface;
use Domain\DiaryApp\Models\Diary\Id;

class Delete extends Controller
{
    private DeleteInterface $deleteDiary;

    public function __construct(DeleteInterface $deleteDiary)
    {
        $this->deleteDiary = $deleteDiary;
    }

    public function __invoke(int $id)
    {
        ($this->deleteDiary)(new Id($id));

        return redirect()->route('diaryApp.diary.index');
    }
}
