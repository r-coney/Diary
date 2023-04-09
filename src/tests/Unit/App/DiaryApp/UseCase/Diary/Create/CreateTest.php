<?php

namespace Tests\Unit\App\DiaryApp\UseCase\Diary\Create;

use DateTime;
use Tests\TestCase;
use App\DiaryApp\UseCase\Diary\Create\Create;
use App\DiaryApp\UseCase\Diary\Create\CreateCommand;
use App\DiaryApp\Infrastructure\Test\DiaryRepository;
use App\Exceptions\DiaryApp\Diary\CanNotCreateDiaryException;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Services\DiaryService;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\InMemoryFactory as DiaryFactory;

class CreateTest extends TestCase
{
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

        $diaryFactory = new DiaryFactory();
        $diaryRepository = new DiaryRepository();
        $diaryService = new DiaryService($diaryRepository);
        $createDiary = new Create($diaryFactory, $diaryService, $diaryRepository);

        $createDiary($createCommand);

        $currentDateTime = new DateTime();
        $createdDiary = $diaryRepository->findByTitleAndCreatedDate(
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

        $diaryFactory = new DiaryFactory();
        $diaryOfExistence = $diaryFactory->create(
            new UserId($userId),
            new CategoryId($mainCategoryId),
            new CategoryId($subCategoryId),
            new Title($title),
            new Content($content),
            new DateTime(),
        );
        $diaryRepository = new DiaryRepository();
        $diaryRepository->save($diaryOfExistence);

        $createCommand = new CreateCommand(
            $userId,
            $title,
            $content,
            $mainCategoryId,
            $subCategoryId
        );
        $diaryService = new DiaryService($diaryRepository);
        $createDiary = new Create($diaryFactory, $diaryService, $diaryRepository);

        $createDiary($createCommand);
    }
}
