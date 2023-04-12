<?php
namespace App\DiaryApp\Infrastructure\Test\Repositories;

use DateTime;
use Domain\DiaryApp\Models\Category\Id;
use Domain\DiaryApp\Models\Category\Name;
use Domain\DiaryApp\Models\Category\Category;
use Domain\DiaryApp\Models\Category\RepositoryInterface as CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    private array $store;

    public function __construct()
    {
        $this->store = [
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

    /**
     * 永続化されたCategory配列を取得
     *
     * @return array
     */
    public function store(): array
    {
        return $this->store;
    }

    public function find(Id $id): Category
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
    }
}