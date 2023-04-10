<?php
namespace App\DiaryApp\UseCase\Diary\GetList;

class DiaryListQueryData implements DiaryListQueryDataInterface
{
    private array $diaryList;

    public function __construct(array $diaryList)
    {
        $this->diaryList = $diaryList;
    }

    public function DiaryList(): array
    {
        return $this->diaryList;
    }
}