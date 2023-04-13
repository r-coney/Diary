<?php

namespace Tests\Unit\App\DiaryApp\UseCase\Diary\GetDetail;

use DateTime;
use Tests\TestCase;
use App\DiaryApp\UseCase\Diary\GetDetail\DiaryData;
use App\DiaryApp\UseCase\Diary\GetDetail\GetDetail;
use App\DiaryApp\Infrastructure\Test\Repositories\DiaryRepository;
use App\Exceptions\DiaryApp\Diary\UseCase\DiaryNotFoundException;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\InMemoryFactory as DiaryFactory;
use Domain\DiaryApp\Models\Diary\FactoryInterface as DiaryFactoryInterface;
use Domain\DiaryApp\Models\Diary\RepositoryInterface as DiaryRepositoryInterface;


class GetDetailTest extends TestCase
{
    private DiaryFactoryInterface $diaryFactory;
    private DiaryRepositoryInterface $diaryRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->diaryFactory = new DiaryFactory();
        $this->diaryRepository = new DiaryRepository($this->diaryFactory);
    }

    /**
     * @test
     */
    public function 日記詳細データを取得できること(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('title'),
            new Content('content'),
            new DateTime(),
        );

        $this->diaryRepository->save($diary);

        $getDetail = new GetDetail($this->diaryRepository);
        $diaryData = $getDetail(new Id($diary->id()));

        $this->assertInstanceOf(DiaryData::class, $diaryData);
    }

    /**
     * @test
     */
    public function 存在しない日記詳細データを取得しようとした場合は例外をthrowすること(): void
    {
        $this->expectException(DiaryNotFoundException::class);

        $getDetail = new GetDetail($this->diaryRepository);
        $getDetail(new Id(1));
    }

    /**
     * @test
     */
    public function 取得した日記データが対象の日記と一致していること(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('title'),
            new Content('content'),
            new DateTime(),
        );

        $this->diaryRepository->save($diary);

        $getDetail = new GetDetail($this->diaryRepository);
        $diaryData = $getDetail(new Id($diary->id()));

        $this->assertSame($diary->id(), $diaryData->id);
        $this->assertSame($diary->userId(), $diaryData->userId);
        $this->assertSame($diary->mainCategoryName(), $diaryData->mainCategoryName);
        $this->assertSame($diary->subCategoryName(), $diaryData->subCategoryName);
        $this->assertSame($diary->title(), $diaryData->title);
        $this->assertSame($diary->content(), $diaryData->content);
        $this->assertSame($diary->createdAt(), $diaryData->createdAt);
        $this->assertSame($diary->updatedAt(), $diaryData->updatedAt);
    }
}
