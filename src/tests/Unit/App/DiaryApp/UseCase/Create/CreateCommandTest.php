<?php

namespace Tests\Unit\App\DiaryApp\UseCase\Create;

use Tests\TestCase;
use App\DiaryApp\UseCase\Diary\Create\CreateCommand;

class CreateCommandTest extends TestCase
{
    /**
     * title()
     * @test
     */
    public function titleを取得できること(): void
    {
        $excepted = 'タイトル';
        $mainCategoryId = 1;
        $subCategoryId = 2;

        $createCommand = new CreateCommand(
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
        $mainCategoryId = 1;
        $subCategoryId = 2;

        $createCommand = new CreateCommand(
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
        $subCategoryId = 2;

        $createCommand = new CreateCommand(
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
        $mainCategoryId = 1;

        $createCommand = new CreateCommand(
            'タイトル',
            '本文',
            $mainCategoryId,
            $excepted,
        );

        $this->assertSame($excepted, $createCommand->subCategoryId());
    }
}
