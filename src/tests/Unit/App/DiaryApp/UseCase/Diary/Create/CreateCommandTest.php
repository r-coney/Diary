<?php

namespace Tests\Unit\App\DiaryApp\UseCase\Diary\Create;

use Tests\TestCase;
use App\DiaryApp\UseCase\Diary\Create\CreateCommand;

class CreateCommandTest extends TestCase
{
    /**
     * userId()
     * @test
     */
    public function userIdを取得できること(): void
    {
        $excepted = 1;
        $mainCategoryId = 1;
        $subCategoryId = 2;

        $createCommand = new CreateCommand(
            $excepted,
            'タイトル',
            '本文',
            $mainCategoryId,
            $subCategoryId
        );

        $this->assertSame($excepted, $createCommand->userId());
    }

    /**
     * title()
     * @test
     */
    public function titleを取得できること(): void
    {
        $excepted = 'タイトル';
        $userId = 1;
        $mainCategoryId = 1;
        $subCategoryId = 2;

        $createCommand = new CreateCommand(
            $userId,
            $excepted,
            '本文',
            $mainCategoryId,
            $subCategoryId
        );

        $this->assertSame($excepted, $createCommand->title());
    }

    /**
     * content()
     * @test
     */
    public function contentを取得できること(): void
    {
        $excepted = '本文';
        $userId = 1;
        $mainCategoryId = 1;
        $subCategoryId = 2;

        $createCommand = new CreateCommand(
            $userId,
            'タイトル',
            $excepted,
            $mainCategoryId,
            $subCategoryId
        );

        $this->assertSame($excepted, $createCommand->content());
    }

    /**
     * mainCategoryId()
     * @test
     *
     * @return void
     */
    public function mainCategoryIdを取得できること(): void
    {
        $excepted = 1;
        $userId = 1;
        $subCategoryId = 2;

        $createCommand = new CreateCommand(
            $userId,
            'タイトル',
            '本文',
            $excepted,
            $subCategoryId
        );

        $this->assertSame($excepted, $createCommand->mainCategoryId());
    }

    /**
     * subCategoryId()
     * @test
     *
     * @return void
     */
    public function subCategoryIdを取得できること(): void
    {
        $excepted = 2;
        $userId = 1;
        $mainCategoryId = 1;

        $createCommand = new CreateCommand(
            $userId,
            'タイトル',
            '本文',
            $mainCategoryId,
            $excepted,
        );

        $this->assertSame($excepted, $createCommand->subCategoryId());
    }
}
