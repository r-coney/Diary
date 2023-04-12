<?php
namespace Domain\DiaryApp\Models\Category;

use Domain\DiaryApp\Models\Category\Id;
use Domain\DiaryApp\Models\Category\Category;

interface RepositoryInterface
{
    public function find(Id $id): Category;
}
