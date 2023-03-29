<?php

namespace Tests\Unit\Domain\DiaryApp\Models\Category;

use Tests\TestCase;
use Domain\DiaryApp\Models\Category\Id;
use Domain\DiaryApp\Models\Category\Name;
use Domain\DiaryApp\Models\Category\Category;

class CategoryTest extends TestCase
{
    /**
     * @test
     */
    public function Categoryモデルを作成できること(): void
    {
        $category = new Category(
            new Id(1),
            new Name('名前'),
            date("Y-m-d H:i:s")
        );

        $this->assertInstanceOf(Category::class, $category);
    }

    /**
     * id()
     * @test
     */
    public function IDを取得できること(): void
    {
        $expected = new Id(1);

        $category = new Category(
            new Id(1),
            new Name('名前'),
            date('Y-m-d H:i:s')
        );

        $this->assertSame($expected->value(), $category->id());
    }

    /**
     * name()
     * @test
     */
    public function カテゴリー名を取得できること(): void
    {
        $expected = new Name('名前');

        $category = new Category(
            new Id(1),
            $expected,
            date('Y-m-d H:i:s')
        );

        $this->assertSame($expected->value(), $category->name());
    }

    /**
     * createdAt()
     * @test
     */
    public function 登録日時を取得できること(): void
    {
        $expected = date('Y-m-d H:i:s');

        $category = new Category(
            new Id(1),
            new Name('名前'),
            $expected
        );

        $this->assertSame($expected, $category->createdAt());
    }

    /**
     * updatedAt()
     * @test
     */
    public function 更新日時を取得できること(): void
    {
        $expected = date('Y-m-d H:i:s');

        $category = new Category(
            new Id(1),
            new Name('名前'),
            date('Y-m-d H:i:s'),
            $expected
        );

        $this->assertSame($expected, $category->updatedAt());
    }

    /**
     * changeName()
     * @test
     */
    public function 名前を変更できること(): void
    {
        $category = new Category(
            new Id(1),
            new Name('名前'),
            date('Y-m-d H:i:s')
        );

        $expected = new Name('変更後の名前');
        $category->changeName($expected);

        $this->assertSame($expected->value(), $category->name());
        $this->assertNotNull($category->updatedAt());
    }

    /**
     * equals()
     * @test
     */
    public function 同じカテゴリーモデル同士で比較した場合、trueを返すこと(): void
    {
        $category = new Category(
            new Id(1),
            new Name('名前'),
            date('Y-m-d H:i:s')
        );

        $this->assertTrue($category->equals($category));
    }

    /**
     * equals()
     * @test
     */
    public function 別のカテゴリーモデルと比較した場合、falseを返すこと(): void
    {
        $category = new Category(
            new Id(1),
            new Name('名前'),
            date('Y-m-d H:i:s')
        );

        $otherCategory = new Category(
            new Id(2),
            new Name('別の名前'),
            date('Y-m-d H:i:s')
        );

        $this->assertFalse($category->equals($otherCategory));
    }

    /**
     * equals()
     * @test
     */
    public function nullと比較した場合、falseを返すこと(): void
    {
        $category = new Category(
            new Id(1),
            new Name('名前'),
            date('Y-m-d H:i:s')
        );

        $this->assertFalse($category->equals(null));
    }
}
