<?php

namespace Tests\Unit\Domain\DiaryApp\Services;

use DateTime;
use Tests\TestCase;
use Domain\DiaryApp\Models\Category\Name;
use Domain\DiaryApp\Models\Category\Category;
use Domain\DiaryApp\Services\CategoryService;
use Domain\DiaryApp\Models\Category\Id;
use App\DiaryApp\Infrastructure\Test\Repositories\CategoryRepository;
use Domain\DiaryApp\Models\Category\RepositoryInterface as CategoryRepositoryInterface;

class CategoryServiceTest extends TestCase
{
    private CategoryRepositoryInterface $categoryRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->categoryRepository = new CategoryRepository();
    }

    /**
     * @exists
     * @test
     */
    public function Categoryが存在する場合、trueを返すこと(): void
    {

        $category = $this->categoryRepository->find(new Id(1));

        $categoryService = new CategoryService($this->categoryRepository);
        $actual = $categoryService->exists(new Id($category->id()));

        $this->assertTrue($actual);
    }

    /**
     * @exists
     * @test
     */
    public function Categoryが存在しない場合、falseを返すこと(): void
    {
        $category = new Category(
            new Id(999),
            new Name('存在しないカテゴリー'),
            new DateTime('2021-01-01 00:00:00'),
        );

        $categoryService = new CategoryService($this->categoryRepository);
        $actual = $categoryService->exists(new Id($category->id()));

        $this->assertFalse($actual);
    }
}

