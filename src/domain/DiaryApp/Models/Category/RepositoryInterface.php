<?php
namespace Domain\DiaryApp\Models\Category;

use Domain\DiaryApp\Models\Category\Id;
use Domain\DiaryApp\Models\Category\Category;

interface RepositoryInterface
{
    /**
     * IDに紐づくカテゴリーを取得
     *
     * @param Id $id
     * @return Category|null
     */
    public function find(Id $id): ?Category;
}
