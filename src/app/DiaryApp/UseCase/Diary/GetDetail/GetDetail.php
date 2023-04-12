<?php
namespace App\DiaryApp\UseCase\Diary\GetDetail;

class GetDetail
{
    public function __invoke(Id $id): DiaryDetailedData
    {
        // categoryをDiaryEntityに持たせる
        $diary = $this->diaryRepository->findById($id);
        $diaryDetailedData = new DiaryDetailedData($diary);
        return $diaryDetailedData;
    }
}