<?php

namespace Tests\Unit\App\DiaryApp\UseCase\Diary\Edit;

use DateTime;
use Tests\TestCase;
use App\DiaryApp\Infrastructure\Test\Repositories\CategoryRepository;
use App\DiaryApp\UseCase\Diary\Edit\Edit;
use App\DiaryApp\UseCase\Diary\Edit\EditCommand;
use App\DiaryApp\Infrastructure\Test\Repositories\DiaryRepository;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\InMemoryFactory as DiaryFactory;
use Domain\DiaryApp\Models\Diary\FactoryInterface as DiaryFactoryInterface;
use Domain\DiaryApp\Models\Diary\RepositoryInterface as DiaryRepositoryInterface;
use Domain\DiaryApp\Models\Category\RepositoryInterface as CategoryRepositoryInterface;

class EditTest extends TestCase
{
    private DiaryFactoryInterface $diaryFactory;
    private DiaryRepositoryInterface $diaryRepository;
    private CategoryRepositoryInterface $categoryRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->diaryFactory = new DiaryFactory();
        $this->diaryRepository = new DiaryRepository($this->diaryFactory);
        $this->categoryRepository = new CategoryRepository();
    }

    /**
     * @test
     */
    public function 日記を編集できること(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('コンテンツ'),
            new DateTime(),
        );

        $this->diaryRepository->save($diary);

        $mainCategoryId = 3;
        $subCategoryId = 1;
        $editCommand = new EditCommand(
            $diary->id(),
            '編集後タイトル',
            '編集後コンテンツ',
            $mainCategoryId,
            $subCategoryId,
        );

        $editDiary = new Edit(
            $this->diaryRepository,
            $this->categoryRepository,
        );

        $editDiary($editCommand);
        $editedDiary = $this->diaryRepository->find(new Id($editCommand->diaryId()));

        $this->assertSame($editCommand->title(), $editedDiary->title());
        $this->assertSame($editCommand->content(), $editedDiary->content());
        $this->assertSame($editCommand->mainCategoryId(), $editedDiary->mainCategoryId());
        $this->assertSame($editCommand->subCategoryId(), $editedDiary->subCategoryId());
    }
}
