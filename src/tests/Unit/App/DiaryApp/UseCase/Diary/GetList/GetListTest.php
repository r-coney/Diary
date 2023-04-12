<?php

namespace Tests\Unit\App\DiaryApp\UseCase\Diary\GetList;

use DateTime;
use Tests\TestCase;
use App\DiaryApp\UseCase\Diary\GetList\GetList;
use App\DiaryApp\UseCase\Diary\GetList\GetListCommand;
use App\DiaryApp\UseCase\Diary\GetList\DiaryListQueryData;
use App\DiaryApp\Infrastructure\Test\Queries\DiaryQueryService;
use App\DiaryApp\UseCase\Diary\QueryServiceInterface as DiaryQueryServiceInterface;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\InMemoryFactory as DiaryFactory;
use Domain\DiaryApp\Models\Diary\FactoryInterface as DiaryFactoryInterface;

class GetListTest extends TestCase
{
    private DiaryQueryServiceInterface $diaryQueryService;
    private DiaryFactoryInterface $diaryFactory;

    public function setUp(): void
    {
        parent::setUp();
        $this->diaryQueryService = new DiaryQueryService();
        $this->diaryFactory = new DiaryFactory();
    }

    /**
     * @test
     */
    public function 日記一覧を取得できること(): void
    {
        $userId = new UserId(1);
        $this->diaryQueryService->add($this->diaryFactory->create(
            $userId,
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
        ));

        $this->diaryQueryService->add($this->diaryFactory->create(
            $userId,
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル2'),
            new Content('本文2'),
            new DateTime(),
        ));

        $getList = new GetList($this->diaryQueryService);
        $perPage = 10;
        $page = 1;
        $getListCommand = new GetListCommand(
            $userId->value(),
            $perPage,
            $page,
        );
        $diaryListData = $getList($getListCommand);

        $this->assertInstanceOf(DiaryListQueryData::class, $diaryListData);
        $this->assertSame(count($this->diaryQueryService->store()), count($diaryListData->diaryList()));
    }
}
