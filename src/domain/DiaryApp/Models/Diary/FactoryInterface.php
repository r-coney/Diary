<?php
namespace Domain\DiaryApp\Models\Diary;

use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Diary;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;

interface FactoryInterface
{
    /**
     * Diaryモデルを作成
     *
     * @param UserId $userId
     * @param CategoryId $mainCategoryId
     * @param CategoryId|null $subCategoryId
     * @param Title $title
     * @param Content|null $content
     * @param string $createdAt
     * @param string|null $updatedAt
     * @param Id|null $id
     * @return Diary
     */
    public function create(
        UserId $userId,
        CategoryId $mainCategoryId,
        ?CategoryId $subCategoryId,
        Title $title,
        ?Content $content,
        string $createdAt,
        ?string $updatedAt = null,
        Id $id = null,
    ): Diary;
}
