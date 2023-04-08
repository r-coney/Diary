<?php
namespace Domain\DiaryApp\Models\Diary;

use DateTime;
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
     * @param DateTime $createdAt
     * @param DateTime|null $updatedAt
     * @param Id|null $id
     * @return Diary
     */
    public function create(
        UserId $userId,
        CategoryId $mainCategoryId,
        ?CategoryId $subCategoryId,
        Title $title,
        ?Content $content,
        DateTime $createdAt,
        ?DateTime $updatedAt = null,
        Id $id = null,
    ): Diary;
}
