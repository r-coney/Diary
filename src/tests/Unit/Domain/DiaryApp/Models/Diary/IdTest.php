<?php

namespace Tests\Unit\Domain\DiaryApp\Models\Diary;

use Tests\TestCase;
use Domain\DiaryApp\Models\Diary\Id;
use Domain\DiaryApp\Exceptions\Diary\InvalidIdException;

class IdTest extends TestCase
{
    /**
     * value()
     * @test
     */
    public function valueが取得できること(): void
    {
        $expectedNumber = 1;
        $id = new Id($expectedNumber);

        $this->assertSame($expectedNumber, $id->value());
    }

    /**
     *
     * @test
     */
    public function idに無効な値を設定した場合、例外をthrowすること(): void
    {
        $this->expectException(InvalidIdException::class);

        new Id(-1);
    }

    /**
     * equals()
     * @test
     */
    public function idが同じ場合、trueを返すこと(): void
    {
        $idNumber = 1;
        $id = new Id($idNumber);
        $otherId = new Id($idNumber);

        $this->assertTrue($id->equals($otherId));
    }

    /**
     * equals()
     * @test
     */
    public function nullと比較した場合、falseを返すこと(): void
    {
        $id = new Id(1);

        $this->assertFalse($id->equals(null));
    }
}
