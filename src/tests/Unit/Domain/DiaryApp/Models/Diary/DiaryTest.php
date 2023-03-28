<?php

namespace Tests\Unit\Domain\DiaryApp\Models\Diary;

use Tests\TestCase;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Diary;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Exceptions\Category\InvalidIdException as InvalidCategoryIdException;

class DiaryTest extends TestCase
{
    /**
     * @test
     */
    public function Diaryモデルを作成できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(2);
        $title = new Title('タイトル');
        $content = new Content('本文');
        $createdAt = date("Y-m-d H:i:s");

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $this->assertInstanceOf(Diary::class, $diary);
    }

    /**
     * @test
     */
    public function メインカテゴリーとサブカテゴリーが同一の場合、Diaryモデルを作成できないこと(): void
    {
        $this->expectException(InvalidCategoryIdException::class);

        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(1);
        $title = new Title('タイトル');
        $content = new Content('本文');
        $createdAt = date('Y-m-d H:i:s');

        new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );
    }

    /**
     * Id()
     * @test
     */
    public function IDを取得できること(): void
    {
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(2);
        $title = new Title('タイトル');
        $content = new Content('本文');
        $createdAt = date('Y-m-d H:i:s');

        $expected = 1;
        $id = new Id($expected);

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $this->assertSame($expected, $diary->id());
    }

    /**
     * userId()
     * @test
     */
    public function ユーザーIDを取得できること(): void
    {
        $id = new Id(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(2);
        $title = new Title('タイトル');
        $content = new Content('本文');
        $createdAt = date('Y-m-d H:i:s');

        $expected = 1;
        $userId = new UserId($expected);

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $this->assertSame($expected, $diary->userId());
    }

    /**
     * mainCategoryId()
     * @test
     */
    public function メインカテゴリーを取得できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $subCategoryId = new CategoryId(2);
        $title = new Title('タイトル');
        $content = new Content('本文');
        $createdAt = date('Y-m-d H:i:s');

        $expected = 1;
        $mainCategoryId = new CategoryId($expected);

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $this->assertSame($expected, $diary->mainCategoryId());
    }

    /**
     * subCategoryId()
     * @test
     */
    public function サブカテゴリーを取得できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $title = new Title('タイトル');
        $content = new Content('本文');
        $createdAt = date('Y-m-d H:i:s');

        $expected = 2;
        $subCategoryId = new CategoryId($expected);

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $this->assertSame($expected, $diary->subCategoryId());
    }

    /**
     * subCategoryId()
     * @test
     */
    public function サブカテゴリーが設定されていない場合、nullを取得できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $title = new Title('タイトル');
        $content = new Content('本文');
        $createdAt = date('Y-m-d H:i:s');

        $expected = null;
        $subCategoryId = $expected;

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $this->assertSame($expected, $diary->subCategoryId());
    }

    /**
     * title()
     * @test
     */
    public function タイトルを取得できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(2);
        $content = new Content('本文');
        $createdAt = date('Y-m-d H:i:s');

        $expected = 'タイトル';
        $title = new Title($expected);

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $this->assertSame($expected, $diary->title());
    }

     /**
     * content()
     * @test
     */
    public function 本文を取得できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(2);
        $title = new Title('タイトル');
        $createdAt = date('Y-m-d H:i:s');

        $expected = '本文';
        $content = new Content($expected);

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $this->assertSame($expected, $diary->content());
    }

    /**
     * content()
     * @test
     */
    public function 本文が設定されていない場合、nullを取得できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(2);
        $title = new Title('タイトル');
        $createdAt = date('Y-m-d H:i:s');

        $expected = null;
        $content = $expected;

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $this->assertSame($expected, $diary->content());
    }

    /**
     * createdAt()
     * @test
     */
    public function 登録日時を取得できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(2);
        $title = new Title('タイトル');
        $content = new Content('本文');

        $expected = date('Y-m-d H:i:s');
        $createdAt = $expected;

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $this->assertSame($expected, $diary->createdAt());
    }

    /**
     * changeMainCategory()
     * @test
     */
    public function メインカテゴリーを変更できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(2);
        $title = new Title('タイトル');
        $content = new Content('本文');
        $createdAt = date('Y-m-d H:i:s');

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $expected = 3;
        $diary->changeMainCategoryId(new CategoryId($expected));

        $this->assertSame($expected, $diary->mainCategoryId());
        $this->assertNotNull($diary->updatedAt());
    }

    /**
     * changeSubCategory()
     * @test
     */
    public function サブカテゴリーを変更できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(2);
        $title = new Title('タイトル');
        $content = new Content('本文');
        $createdAt = date('Y-m-d H:i:s');

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $expected = 3;
        $diary->changeSubCategoryId(new CategoryId($expected));

        $this->assertSame($expected, $diary->subCategoryId());
        $this->assertNotNull($diary->updatedAt());
    }

    /**
     * changeTitle()
     * @test
     */
    public function タイトルを変更できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(2);
        $title = new Title('タイトル');
        $content = new Content('本文');
        $createdAt = date('Y-m-d H:i:s');

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $expected = '変更後タイトル';
        $diary->changeTitle(new Title($expected));

        $this->assertSame($expected, $diary->title());
        $this->assertNotNull($diary->updatedAt());
    }

    /**
     * changeContent()
     * @test
     */
    public function 本文を変更できること(): void
    {
        $id = new Id(1);
        $userId = new UserId(1);
        $mainCategoryId = new CategoryId(1);
        $subCategoryId = new CategoryId(2);
        $title = new Title('タイトル');
        $content = new Content('本文');
        $createdAt = date('Y-m-d H:i:s');

        $diary = new Diary(
            $id,
            $userId,
            $mainCategoryId,
            $subCategoryId,
            $title,
            $content,
            $createdAt
        );

        $expected = '変更後本文';
        $diary->changeContent(new Content($expected));

        $this->assertSame($expected, $diary->content());
        $this->assertNotNull($diary->updatedAt());
    }
}
