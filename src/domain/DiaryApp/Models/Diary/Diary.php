<?php
namespace Domain\DiaryApp\Models\Diary;

use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;

class Todo
{
    private Id $id;
    private UserId $userId;
    private CategoryId $mainCategoryId;
    private ?CategoryId $subCategoryId;
    private Title $title;
    private ?Content $content;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(
        Id $id,
        UserId $userId,
        CategoryId $mainCategoryId,
        CategoryId $subCategoryId,
        Title $title,
        ?Content $content,
        string $createdAt,
        string $updatedAt
    ) {
        if (is_null($id)) {
            throw new InvalidArgumentException('id is required');
        }

        if (is_null($userId)) {
            throw new InvalidArgumentException('userId is required');
        }

        if (is_null($mainCategoryId)) {
            throw new InvalidArgumentException('mainCategoryId is required');
        }

        if (is_null($title)) {
            throw new InvalidArgumentException('title is required');
        }

        if (is_null($createdAt)) {
            throw new InvalidArgumentException('createdAt is required');
        }

        if (is_null($updatedAt)) {
            throw new InvalidArgumentException('updatedAt is required');
        }

        $this->id = $id;
        $this->userId = $userId;
        $this->mainCategoryId = $mainCategoryId;
        $this->subCategoryId = $subCategoryId;
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
