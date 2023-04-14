<?php

namespace Tests\Unit\App\DiaryApp\UseCase\Diary\Delete;

use DateTime;
use Tests\TestCase;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use App\DiaryApp\UseCase\Diary\Delete\Delete;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\InMemoryFactory as DiaryFactory;
use App\DiaryApp\Infrastructure\Test\Repositories\DiaryRepository;
use Domain\DiaryApp\Models\Diary\FactoryInterface as DiaryFactoryInterface;
use Domain\DiaryApp\Models\Diary\RepositoryInterface as DiaryRepositoryInterface;

class DeleteTest extends TestCase
{
    private DiaryFactoryInterface $diaryFactory;
    private DiaryRepositoryInterface $diaryRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->diaryFactory = new DiaryFactory();
        $this->diaryRepository = new DiaryRepository($this->diaryFactory);
    }

    /**
     * @test
     */
    public function 日記を削除できること(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('内容'),
            new DateTime()
        );

        $this->diaryRepository->save($diary);

        $deleteDiary = new Delete($this->diaryRepository);
        $deleteDiary(new Id($diary->id()));

        $this->assertNull($this->diaryRepository->find(new Id($diary->id())));
    }

    /**
     * @test
     */
    public function 存在しない日記を削除しようとした場合もエラーにならないこと(): void
    {
        $deleteDiary = new Delete($this->diaryRepository);
        $deleteDiary(new Id(1));

        $this->assertNull($this->diaryRepository->find(new Id(1)));
    }
}
