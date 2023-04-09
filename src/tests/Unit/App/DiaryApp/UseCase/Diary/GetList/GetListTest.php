<?php

namespace Tests\Unit\App\DiaryApp\UseCase\Diary\GetList;

use DateTime;
use Tests\TestCase;
use App\DiaryApp\UseCase\Diary\GetList\GetList;
use App\DiaryApp\UseCase\Diary\GetList\GetListCommand;
use App\DiaryApp\UseCase\Diary\GetList\DiaryListQueryData;
use App\DiaryApp\Infrastructure\Test\Queries\DiaryQueryService;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\InMemoryFactory as DiaryFactory;;

class GetListTest extends TestCase
{
    /**
     * @test
     */
    public function 日記一覧を取得できること(): void
    {
        $userId = new UserId(1);
        $diaryQueryService = new DiaryQueryService();
        $diaryFactory = new DiaryFactory;
        $diaryQueryService->add($diaryFactory->create(
            $userId,
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
        ));

        $diaryQueryService->add($diaryFactory->create(
            $userId,
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル2'),
            new Content('本文2'),
            new DateTime(),
        ));

        $getList = new GetList($diaryQueryService);
        $perPage = 10;
        $page = 1;
        $getListCommand = new GetListCommand(
            $userId->value(),
            $perPage,
            $page,
        );
        $diaryListData = $getList($getListCommand);

        $this->assertInstanceOf(DiaryListQueryData::class, $diaryListData);
        $this->assertSame(count($diaryQueryService->store()), count($diaryListData->diaryList()));
    }
}
