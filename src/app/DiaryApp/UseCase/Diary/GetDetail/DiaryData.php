<?php
namespace App\DiaryApp\UseCase\Diary\GetDetail;

use Domain\DiaryApp\Models\Diary\Diary;

class DiaryData
{
    public int $id;
    public int $userId;
    public string $mainCategoryName;
    public ?string $subCategoryName;
    public string $title;
    public string $content;
    public string $createdAt;
    public ?string $updatedAt;

    public function __construct(Diary $diaryData)
    {
        $this->id = $diaryData->id();
        $this->userId = $diaryData->userId();
        $this->mainCategoryName = $diaryData->mainCategoryName();
        $this->subCategoryName = $diaryData->subCategoryName();
        $this->title = $diaryData->title();
        $this->content = $diaryData->content();
        $this->createdAt = $diaryData->createdAt();
        $this->updatedAt = $diaryData->updatedAt();
    }
}
