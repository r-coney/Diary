<?php

namespace Tests\Unit\Domain\DiaryApp\Services;

use DateTime;
use Tests\TestCase;
use App\DiaryApp\Infrastructure\Test\Repositories\DiaryRepository;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Services\DiaryService;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\FactoryInterface as DiaryFactoryInterface;
use Domain\DiaryApp\Models\Diary\DiaryRepositoryInterface;
use Domain\DiaryApp\Models\Diary\InMemoryFactory as DiaryFactory;

class DiaryServiceTest extends TestCase
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
     * @exists
     * @test
     */
    public function Diaryがすでに存在する場合、trueを返すこと(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
        );

        $this->diaryRepository->save($diary);

        $diaryService = new DiaryService($this->diaryRepository);
        $actual = $diaryService->exists($diary);

        $this->assertTrue($actual);
    }

    /**
     * @exists
     * @test
     */
    public function Diaryが存在しない場合、falseを返すこと(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
        );

        $diaryService = new DiaryService($this->diaryRepository);
        $actual = $diaryService->exists($diary);

        $this->assertFalse($actual);
    }
}
