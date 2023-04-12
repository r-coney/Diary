<?php
namespace Domain\DiaryApp\Models\Category;

use Domain\DiaryApp\Models\Category\Id;
use Domain\DiaryApp\Models\Category\Category;

interface CategoryRepositoryInterface
{
    public function find(Id $id): Category;
}
