<?php
namespace Domain\DiaryApp\Models\Diary;

use DateTime;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Diary;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Category\Category;
use Domain\DiaryApp\Models\Category\Name as CategoryName;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Diary\FactoryInterface;

class InMemoryFactory implements FactoryInterface
{
    private int $currentId;
    private array $categories;

    public function __construct()
    {
        $this->currentId = 0;
        $this->categories = [
            (object) [
                'id' => 1,
                'name' => 'work',
                'createdAt' => '2021-01-01 00:00:00',
            ],
            (object) [
                'id' => 2,
                'name' => 'study',
                'createdAt' => '2021-01-01 00:00:00',
            ],
            (object) [
                'id' => 3,
                'name' => 'life',
                'createdAt' => '2021-01-01 00:00:00',
            ],
        ];
    }

    public function create(
        UserId $userId,
        CategoryId $mainCategoryId,
        ?CategoryId $subCategoryId,
        Title $title,
        ?Content $content,
        DateTime $createdAt,
        ?DateTime $updatedAt = null,
        ?Id $id = null
    ): Diary {
        $this->currentId++;

        if (is_null($id)) {
            $id = new Id($this->currentId);
        }

        $mainCategory = $this->getCategory($mainCategoryId);
        $subCategory = isset($subCategoryId) ? $this->getCategory($subCategoryId) : null;

        return new Diary(
            $id,
            $userId,
            $mainCategory,
            $subCategory,
            $title,
            $content,
            $createdAt,
            $updatedAt
        );
    }

    public function getCategory(CategoryId $categoryId): Category
    {
        foreach ($this->categories as $entity) {
            if ($categoryId->value() === $entity->id) {
                return new Category(
                    new CategoryId($entity->id),
                    new CategoryName($entity->name),
                    new DateTime($entity->createdAt),
                    isset($entity->updatedAt) ? new DateTime($entity->updatedAt) : null
                );
            }
        }
    }
}