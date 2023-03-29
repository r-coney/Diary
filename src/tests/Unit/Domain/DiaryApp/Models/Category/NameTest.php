<?php

namespace Tests\Unit\Domain\DiaryApp\Models\Category;

use Tests\TestCase;
use Domain\DiaryApp\Models\Category\Name;
use Domain\DiaryApp\Exceptions\Category\InvalidNameException;

class NameTest extends TestCase
{
    /**
     * value()
     * @test
     */
    public function valueが取得できること(): void
    {
        $expectedString = '名前';
        $name = new Name($expectedString);

        $this->assertSame($expectedString, $name->value());
    }

    /**
     * @test
     */
    public function nameに100文字以上を指定した場合、例外をthrowすること(): void
    {
        $this->expectException(InvalidNameException::class);

        new Name(str_repeat('あ', 101));
    }

    /**
     * @test
     */
    public function nameに空文字を指定した場合、例外をthrowすること(): void
    {
        $this->expectException(InvalidNameException::class);

        new Name('');
    }

    /**
     * equals()
     * @test
     */
    public function nameが同じ場合、trueを返すこと(): void
    {
        $nameString = '名前';
        $name = new Name($nameString);
        $otherName = new Name($nameString);

        $this->assertTrue($name->equals($otherName));
    }

    /**
     * equals()
     * @test
     */
    public function nullと比較した場合、falseを返すこと(): void
    {
        $name = new Name('名前');

        $this->assertFalse($name->equals(null));
    }
}
