<?php

namespace Tests\Unit\Domain\DiaryApp\Models\Diary;

use DateTime;
use InvalidArgumentException;
use Tests\TestCase;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Models\Diary\Diary;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Models\Category\Name;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Models\Category\Category;
use Domain\DiaryApp\Models\User\Id as UserId;
use Domain\DiaryApp\Models\Category\Id as CategoryId;
use Domain\DiaryApp\Models\Diary\InMemoryFactory as DiaryFactory;

class DiaryTest extends TestCase
{
    private DiaryFactory $diaryFactory;

    public function setUp(): void
    {
        parent::setUp();
        $this->diaryFactory = new DiaryFactory();
    }

    /**
     * @test
     */
    public function Diaryモデルを作成できること(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
        );

        $this->assertInstanceOf(Diary::class, $diary);
    }

    /**
     * @test
     */
    public function メインカテゴリーとサブカテゴリーが同一の場合、Diaryモデルを作成できないこと(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(1),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
        );
    }

    /**
     * @test
     */
    public function 存在しないカテゴリーを指定した場合、Diaryモデルを作成できないこと(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(999),
            new CategoryId(999),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
        );
    }

    /**
     * id()
     * @test
     */
    public function IDを取得できること(): void
    {
        $expected = new Id(1);

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
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

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
        );

        $this->assertSame($expected->value(), $diary->userId());
    }

    /**
     * mainCategoryId()
     * @test
     */
    public function メインカテゴリーのIDを取得できること(): void
    {
        $expected = new CategoryId(1);

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
        );

        $this->assertSame($expected->value(), $diary->mainCategoryId());
    }

    /**
     * mainCategoryName()
     * @test
     */
    public function メインカテゴリーの名前を取得できること(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
        );

        $this->assertIsString($diary->mainCategoryName());
    }

    /**
     * subCategoryId()
     * @test
     */
    public function サブカテゴリーのIDを取得できること(): void
    {
        $expected = new CategoryId(2);

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
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

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            $expected,
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
        );

        $this->assertSame($expected, $diary->subCategoryId());
    }

    /**
     * subCategoryName()
     * @test
     */
    public function サブカテゴリーの名前を取得できること(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
        );

        $this->assertIsString($diary->subCategoryName());
    }

    /**
     * subCategoryName()
     * @test
     */
    public function サブカテゴリーが設定されていない場合、サブカテゴリー名にnullを取得できること(): void
    {
        $expected = null;

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            null,
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
        );

        $this->assertSame($expected, $diary->subCategoryName());
    }

    /**
     * title()
     * @test
     */
    public function タイトルを取得できること(): void
    {
        $expected = new Title('タイトル');

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            $expected,
            new Content('本文'),
            new DateTime()
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

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime()
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

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            $expected,
            new DateTime()
        );

        $this->assertSame($expected, $diary->content());
    }

    /**
     * createdAt()
     * @test
     */
    public function 登録日時を取得できること(): void
    {
        $expected = new DateTime();

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            $expected
        );

        $this->assertSame($expected->format('Y-m-d H:i:s'), $diary->createdAt());
    }

    /**
     * createdDate()
     * @test
     */
    public function 登録日付を取得できること(): void
    {
        $expected = new DateTime();

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            $expected
        );

        $this->assertSame($expected->format('Y-m-d'), $diary->createdDate());
    }

    /**
     * updatedAt()
     * @test
     */
    public function 更新日時を取得できること(): void
    {
        $expected = new DateTime();

        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
            $expected
        );

        $this->assertSame($expected->format('Y-m-d H:i:s'), $diary->updatedAt());
    }

    /**
     * changeMainCategory()
     * @test
     */
    public function メインカテゴリーを変更できること(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
        );

        $category = new Category(
            new CategoryId(3),
            new Name('カテゴリー3'),
            new DateTime()
        );
        $diary->changeMainCategory($category);

        $this->assertSame($category->id(), $diary->mainCategoryId());
        $this->assertNotNull($diary->updatedAt());
    }

    /**
     * changeSubCategory()
     * @test
     */
    public function サブカテゴリーを変更できること(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
        );

        $category = new Category(
            new CategoryId(3),
            new Name('カテゴリー3'),
            new DateTime()
        );

        $diary->changeSubCategory($category);

        $this->assertSame($category->id(), $diary->subCategoryId());
        $this->assertNotNull($diary->updatedAt());
    }

    /**
     * changeTitle()
     * @test
     */
    public function タイトルを変更できること(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
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
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
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
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
            new DateTime(),
            new Id(1),
        );

        $this->assertTrue($diary->equals($diary));
    }

    /**
     * equals()
     * @test
     */
    public function 別のDiaryモデルと比較した場合、falseを返すこと(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
            new DateTime(),
            new Id(1),
        );

        $otherDiary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
            new DateTime(),
            new Id(2),
        );

        $this->assertFalse($diary->equals($otherDiary));
    }

    /**
     * equals()
     * @test
     */
    public function nullと比較した場合、falseを返すこと(): void
    {
        $diary = $this->diaryFactory->create(
            new UserId(1),
            new CategoryId(1),
            new CategoryId(2),
            new Title('タイトル'),
            new Content('本文'),
            new DateTime(),
        );

        $this->assertFalse($diary->equals(null));
    }
}
