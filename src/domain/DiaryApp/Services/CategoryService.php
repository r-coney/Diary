<?php
namespace Domain\DiaryApp\Services;

use Domain\DiaryApp\Models\Category\Id;
use Domain\DiaryApp\Models\Category\RepositoryInterface as CategoryRepositoryInterface;

class CategoryService
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * CategoryがDBにすでに存在するか検証
     *
     * @param Id $id
     * @return bool
     */
    public function exists(Id $id): bool
    {
        $found = $this->categoryRepository->find($id);

        return $found !== null;
    }
}