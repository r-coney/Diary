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
        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date("Y-m-d H:i:s")
        );

        $this->assertInstanceOf(Diary::class, $diary);
    }

    /**
     * @test
     */
    public function メインカテゴリーとサブカテゴリーが同一の場合、Diaryモデルを作成できないこと(): void
    {
        $this->expectException(InvalidCategoryIdException::class);

        new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(1),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );
    }

    /**
     * id()
     * @test
     */
    public function IDを取得できること(): void
    {
        $expected = new Id(1);

        $diary = new Diary(
            $expected,
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $this->assertSame($expected->value(), $diary->id());
    }

    /**
     * userId()
     * @test
     */
    public function ユーザーIDを取得できること(): void
    {
        $expected = new UserId(1);

        $diary = new Diary(
            new Id(1),
            $expected,
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $this->assertSame($expected->value(), $diary->userId());
    }

    /**
     * mainCategoryId()
     * @test
     */
    public function メインカテゴリーを取得できること(): void
    {
        $expected = new CategoryId(1);

        $diary = new Diary(
            new Id(1),
            new UserId(1),
            $expected,
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $this->assertSame($expected->value(), $diary->mainCategoryId());
    }

    /**
     * subCategoryId()
     * @test
     */
    public function サブカテゴリーを取得できること(): void
    {
        $expected = new CategoryId(2);

        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            $expected,
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $this->assertSame($expected->value(), $diary->subCategoryId());
    }

    /**
     * subCategoryId()
     * @test
     */
    public function サブカテゴリーが設定されていない場合、nullを取得できること(): void
    {
        $expected = null;

        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            $expected,
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $this->assertSame($expected, $diary->subCategoryId());
    }

    /**
     * title()
     * @test
     */
    public function タイトルを取得できること(): void
    {
        $expected = new Title('タイトル');

        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            $expected,
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $this->assertSame($expected->value(), $diary->title());
    }

     /**
     * content()
     * @test
     */
    public function 本文を取得できること(): void
    {
        $expected = new Content('本文');

        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            $expected,
            date('Y-m-d H:i:s')
        );

        $this->assertSame($expected->value(), $diary->content());
    }

    /**
     * content()
     * @test
     */
    public function 本文が設定されていない場合、nullを取得できること(): void
    {
        $expected = null;

        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            $expected,
            date('Y-m-d H:i:s')
        );

        $this->assertSame($expected, $diary->content());
    }

    /**
     * createdAt()
     * @test
     */
    public function 登録日時を取得できること(): void
    {
        $expected = date('Y-m-d H:i:s');

        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            $expected
        );

        $this->assertSame($expected, $diary->createdAt());
    }

    /**
     * updatedAt()
     * @test
     */
    public function 更新日時を取得できること(): void
    {
        $expected = date('Y-m-d H:i:s');

        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s'),
            $expected
        );

        $this->assertSame($expected, $diary->updatedAt());
    }

    /**
     * changeMainCategory()
     * @test
     */
    public function メインカテゴリーを変更できること(): void
    {
        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s'),
        );

        $expected = new CategoryId(3);
        $diary->changeMainCategoryId($expected);

        $this->assertSame($expected->value(), $diary->mainCategoryId());
        $this->assertNotNull($diary->updatedAt());
    }

    /**
     * changeSubCategory()
     * @test
     */
    public function サブカテゴリーを変更できること(): void
    {
        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s'),
        );

        $expected = new CategoryId(3);
        $diary->changeSubCategoryId($expected);

        $this->assertSame($expected->value(), $diary->subCategoryId());
        $this->assertNotNull($diary->updatedAt());
    }

    /**
     * changeTitle()
     * @test
     */
    public function タイトルを変更できること(): void
    {
        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s'),
        );

        $expected = new Title('変更後タイトル');
        $diary->changeTitle($expected);

        $this->assertSame($expected->value(), $diary->title());
        $this->assertNotNull($diary->updatedAt());
    }

    /**
     * changeContent()
     * @test
     */
    public function 本文を変更できること(): void
    {
        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $expected = new Content('変更後本文');
        $diary->changeContent($expected);

        $this->assertSame($expected->value(), $diary->content());
        $this->assertNotNull($diary->updatedAt());
    }

    /**
     * equals()
     * @test
     */
    public function 同じDiaryモデルと比較した場合、trueを返すこと(): void
    {
        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $this->assertTrue($diary->equals($diary));
    }

    /**
     * equals()
     * @test
     */
    public function 別のDiaryモデルと比較した場合、falseを返すこと(): void
    {
        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $otherDiary = new Diary(
            new Id(2),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $this->assertFalse($diary->equals($otherDiary));
    }

    /**
     * equals()
     * @test
     */
    public function nullと比較した場合、falseを返すこと(): void
    {
        $diary = new Diary(
            new Id(1),
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            date('Y-m-d H:i:s')
        );

        $this->assertFalse($diary->equals(null));
    }
}
