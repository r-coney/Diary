<?php
namespace Domain\DiaryApp\Models\Diary;

use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Diary;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Diary\FactoryInterface;
use Domain\DiaryApp\Models\Category\Id as CategoryId;

class InMemoryFactory implements FactoryInterface
{
    private int $currentId;

    public function create(
        UserId $userId,
        CategoryId $mainCategoryId,
        ?CategoryId $subCategoryId,
        Title $title,
        ?Content $content,
        string $createdAt,
        ?string $updatedAt = null,
        ?Id $id = null
    ): Diary {
        $this->currentId++;

        if (is_null($id)) {
            $id = new UserId($this->currentId);
        }

        return new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt,
            $updatedAt
        );
    }
}