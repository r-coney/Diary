<?php

namespace Tests\Unit\App\DiaryApp\UseCase\Diary\Edit;

use PHPUnit\Framework\TestCase;
use App\DiaryApp\UseCase\Diary\Edit\EditCommand;

class EditCommandTest extends TestCase
{
    /**
     * @test
     */
    public function コンストラクタの引数が正しく設定されていること()
    {
        $diaryId = 1;
        $title = 'テストタイトル';
        $content = 'テストコンテンツ';
        $mainCategoryId = 2;
        $subCategoryId = 3;

        $command = new EditCommand($diaryId, $title, $content, $mainCategoryId, $subCategoryId);

        $this->assertEquals($command->diaryId(), $diaryId);
        $this->assertEquals($command->title(), $title);
        $this->assertEquals($command->content(), $content);
        $this->assertEquals($command->mainCategoryId(), $mainCategoryId);
        $this->assertEquals($command->subCategoryId(), $subCategoryId);
    }

    /**
     * @test
     */
    public function contentがnullでもコンストラクタが正しく動作すること()
    {
        $diaryId = 1;
        $title = 'テストタイトル';
        $content = null;
        $mainCategoryId = 2;
        $subCategoryId = 3;

        $command = new EditCommand($diaryId, $title, $content, $mainCategoryId, $subCategoryId);

        $this->assertEquals($command->diaryId(), $diaryId);
        $this->assertEquals($command->title(), $title);
        $this->assertEquals($command->content(), $content);
        $this->assertEquals($command->mainCategoryId(), $mainCategoryId);
        $this->assertEquals($command->subCategoryId(), $subCategoryId);
    }

    /**
     * @test
     */
    public function subCategoryIdがnullでもコンストラクタが正しく動作すること()
    {
        $diaryId = 1;
        $title = 'テストタイトル';
        $content = 'テストコンテンツ';
        $mainCategoryId = 2;
        $subCategoryId = null;

        $command = new EditCommand($diaryId, $title, $content, $mainCategoryId, $subCategoryId);

        $this->assertEquals($command->diaryId(), $diaryId);
        $this->assertEquals($command->title(), $title);
        $this->assertEquals($command->content(), $content);
        $this->assertEquals($command->mainCategoryId(), $mainCategoryId);
        $this->assertEquals($command->subCategoryId(), $subCategoryId);
    }
}
