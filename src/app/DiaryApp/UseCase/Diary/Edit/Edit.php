<?php
namespace App\DiaryApp\UseCase\Diary\Edit;

use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use App\DiaryApp\UseCase\Diary\Edit\EditCommandInterface;
use Domain\DiaryApp\Models\Diary\RepositoryInterface as DiaryRepositoryInterface;
use Domain\DiaryApp\Models\Category\RepositoryInterface as CategoryRepositoryInterface;

class Edit implements EditInterface
{
    private DiaryRepositoryInterface $diaryRepository;
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(
        DiaryRepositoryInterface $diaryRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->diaryRepository = $diaryRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(EditCommandInterface $command): void
    {
        $diary = $this->diaryRepository->find(new Id($command->diaryId()));
        $diary->changeTitle(new Title($command->title()));
        $diary->changeContent(new Content($command->content()));

        $mainCategory = $this->categoryRepository->find(new CategoryId($command->mainCategoryId()));
        $diary->changeMainCategory($mainCategory);
        if ($command->hasSubCategoryId()) {
            $subCategory = $this->categoryRepository->find(new CategoryId($command->subCategoryId()));
        } else {
            $subCategory = null;
        }
        $diary->changeSubCategory($subCategory);

        $this->diaryRepository->save($diary);
    }
}
