<?php
namespace Tests\Unit\Domain\DiaryApp\Models\Diary;

use Tests\TestCase;
use Domain\DiaryApp\Models\Diary\Content;
use Domain\DiaryApp\Exceptions\Diary\InvalidContentException;

class ContentTest extends TestCase
{
    /**
     * value()
     * @test
     */
    public function valueが取得できること(): void
    {
        $expectedString = '本文';
        $content = new Content($expectedString);

        $this->assertSame($expectedString, $content->value());
    }

    /**
     * @test
     */
    public function contentが500文字を超えている場合、例外をthrowすること(): void
    {
        $this->expectException(InvalidContentException::class);

        new Content(str_repeat('あ', 501));
    }

    /**
     * @test
     */
    public function nullを指定した場合、空文字列が設定されること(): void
    {
        $content = new Content(null);

        $this->assertSame('', $content->value());
    }

    /**
     * equals()
     * @test
     */
    public function contentが同じ場合、trueを返すこと(): void
    {
        $contentString = '本文';
        $content = new Content($contentString);
        $otherContent = new Content($contentString);

        $this->assertTrue($content->equals($otherContent));
    }

    /**
     * equals()
     * @test
     */
    public function nullと比較した場合、falseを返すこと(): void
    {
        $content = new Content('本文');

        $this->assertFalse($content->equals(null));
    }
}
