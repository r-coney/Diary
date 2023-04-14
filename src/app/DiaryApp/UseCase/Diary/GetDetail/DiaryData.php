<?php
namespace App\DiaryApp\UseCase\Diary\GetDetail;

use Domain\DiaryApp\Models\Diary\Diary;

class DiaryData
{
    public int $id;
    public int $userId;
    public string $mainCategoryName;
    public int $mainCategoryId;
    public ?string $subCategoryName;
    public ?int $subCategoryId;
    public string $title;
    public string $content;
    public string $createdAt;
    public ?string $updatedAt;

    public function __construct(Diary $diary)
    {
        $this->id = $diary->id();
        $this->userId = $diary->userId();
        $this->mainCategoryName = $diary->mainCategoryName();
        $this->mainCategoryId = $diary->mainCategoryId();
        $this->subCategoryName = $diary->subCategoryName();
        $this->subCategoryId = $diary->subCategoryId();
        $this->title = $diary->title();
        $this->content = $diary->content();
        $this->createdAt = $diary->createdAt();
        $this->updatedAt = $diary->updatedAt();
    }
}
