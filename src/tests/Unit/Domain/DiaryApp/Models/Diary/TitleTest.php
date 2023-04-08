<?php

namespace Tests\Unit\Domain\DiaryApp\Models\Diary;

use Tests\TestCase;
use Domain\DiaryApp\Models\Diary\Title;
use Domain\DiaryApp\Exceptions\Diary\InvalidTitleException;

class TitleTest extends TestCase
{
    /**
     * value()
     * @test
     */
    public function valueが取得できること(): void
    {
        $expectedString = 'タイトル';
        $title = new Title($expectedString);

        $this->assertSame($expectedString, $title->value());
    }

    /**
     * @test
     */
    public function titleに100文字以上を指定した場合、例外をthrowすること(): void
    {
        $this->expectException(InvalidTitleException::class);

        new Title(str_repeat('あ', 101));
    }

    /**
     * @test
     */
    public function titleに空文字を指定した場合、例外をthrowすること(): void
    {
        $this->expectException(InvalidTitleException::class);

        new Title('');
    }

    /**
     * equals()
     * @test
     */
    public function titleが同じ場合、trueを返すこと(): void
    {
        $titleString = 'タイトル';
        $title = new Title($titleString);
        $otherTitle = new Title($titleString);

        $this->assertTrue($title->equals($otherTitle));
    }

    /**
     * equals()
     * @test
     */
    public function nullと比較した場合、falseを返すこと(): void
    {
        $id = new Title('タイトル');

        $this->assertFalse($id->equals(null));
    }
}
