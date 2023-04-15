<?php
namespace App\DiaryApp\Infrastructure\InMemory\Repositories;

use DateTime;
use Illuminate\Support\Facades\Cache;
use Domain\DiaryApp\Models\Category\Id;
use Domain\DiaryApp\Models\Category\Name;
use Domain\DiaryApp\Models\Category\Category;
use Domain\DiaryApp\Models\Category\RepositoryInterface as CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * 永続化されたDiary配列を取得
     *
     * @return array
     */
    public function store(): array
    {
        $this->store = Cache::get('categories', []);

        return $this->store;
    }

    public function find(Id $id): ?Category
    {
        foreach ($this->store() as $entity) {
            if ($id->value() === $entity->id) {
                return new Category(
                    new Id($entity->id),
                    new Name($entity->name),
                    new DateTime($entity->createdAt),
                    isset($entity->updatedAt) ? new DateTime($entity->updatedAt) : null
                );
            }
        }

        return null;
    }
}
