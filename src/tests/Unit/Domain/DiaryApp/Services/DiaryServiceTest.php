<?php

namespace Tests\Unit\Domain\DiaryApp\Services;

use Tests\TestCase;
use App\DiaryApp\Infrastructure\Test\DiaryRepository;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Diary;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Services\DiaryService;

class DiaryServiceTest extends TestCase
{
    /**
     * @exists
     * @test
     */
    public function Diaryがすでに存在する場合、trueを返すこと(): void
    {
        $diaryRepository = new DiaryRepository();

        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $diaryRepository = new DiaryRepository();
        $diaryRepository->save($diary);

        $diaryService = new DiaryService($diaryRepository);
        $actual = $diaryService->exists($diary);

        $this->assertTrue($actual);
    }
}
