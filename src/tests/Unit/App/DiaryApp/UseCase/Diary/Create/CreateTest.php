<?php

namespace Tests\Unit\App\DiaryApp\UseCase\Diary\Create;

use DateTime;
use Tests\TestCase;
use App\DiaryApp\UseCase\Diary\Create\Create;
use App\DiaryApp\UseCase\Diary\Create\CreateCommand;
use App\DiaryApp\Infrastructure\Test\Repositories\DiaryRepository;
use App\Exceptions\DiaryApp\Diary\CanNotCreateDiaryException;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Services\DiaryService;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\InMemoryFactory as DiaryFactory;
use Domain\DiaryApp\Models\Diary\FactoryInterface as DiaryFactoryInterface;
use Domain\DiaryApp\Models\Diary\DiaryRepositoryInterface;

class CreateTest extends TestCase
{
    private DiaryFactoryInterface $diaryFactory;
    private DiaryRepositoryInterface $diaryRepository;
    private DiaryService $diaryService;

    public function setUp(): void
    {
        parent::setUp();
        $this->diaryFactory = new DiaryFactory();
        $this->diaryRepository = new DiaryRepository($this->diaryFactory);
        $this->diaryService = new DiaryService($this->diaryRepository);
    }

    /**
     * @test
     */
    public function 日記を作成できること(): void
    {
        $userId = 1;
        $mainCategoryId = 1;
        $subCategoryId = 2;
        $createCommand = new CreateCommand(
            $userId,
            'タイトル',
            '本文',
            $mainCategoryId,
            $subCategoryId
        );

        $createDiary = new Create($this->diaryFactory, $this->diaryService, $this->diaryRepository);

        $createDiary($createCommand);

        $currentDateTime = new DateTime();
        $createdDiary = $this->diaryRepository->findByTitleAndCreatedDate(
            new Title($createCommand->title()),
            $currentDateTime->format('Y-m-d')
        );

        $this->assertSame($createCommand->title(), $createdDiary->title());
        $this->assertSame($createCommand->content(), $createdDiary->content());
        $this->assertSame($createCommand->mainCategoryId(), $createdDiary->mainCategoryId());
        $this->assertSame($createCommand->subCategoryId(), $createdDiary->subCategoryId());
    }

    /**
     * @test
     */
    public function すでに同じ日付とタイトルの組みわせが存在する場合、日記の作成に失敗すること(): void
    {
        $this->expectException(CanNotCreateDiaryException::class);

        $userId = 1;
        $title = 'タイトル';
        $content = '本文';
        $mainCategoryId = 1;
        $subCategoryId = 2;

        $diaryOfExistence = $this->diaryFactory->create(
            new UserId($userId),
            new CategoryId($mainCategoryId),
            new CategoryId($subCategoryId),
            new Title($title),
            new Content($content),
            new DateTime(),
        );

        $this->diaryRepository->save($diaryOfExistence);

        $createCommand = new CreateCommand(
            $userId,
            $title,
            $content,
            $mainCategoryId,
            $subCategoryId
        );

        $createDiary = new Create($this->diaryFactory, $this->diaryService, $this->diaryRepository);

        $createDiary($createCommand);
    }
}
