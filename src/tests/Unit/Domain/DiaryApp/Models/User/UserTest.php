<?php

namespace Tests\Unit\Domain\DiaryApp\Models\User;

use PHPUnit\Framework\TestCase;
use Domain\DiaryApp\Models\User\Id;
use Domain\DiaryApp\Models\User\User;
use InvalidArgumentException;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function Userモデルを作成できること(): void
    {
        $user = new User(
            new Id(1),
            '名前'
        );

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     */
    public function ユーザー名が空文字の場合、例外をthrowすること(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new User(
            new Id(1),
            ''
        );
    }

    /**
     * id()
     * @test
     */
    public function IDを取得できること(): void
    {
        $expected = new Id(1);

        $user = new User(
            new Id(1),
            '名前'
        );

        $this->assertSame($expected->value(), $user->id());
    }

    /**
     * name()
     * @test
     */
    public function ユーザー名を取得できること(): void
    {
        $expected = '名前';

        $user = new User(
            new Id(1),
            $expected,
        );

        $this->assertSame($expected, $user->name());
    }

    /**
     * equals()
     * @test
     */
    public function 同じUserモデル同士で比較した場合、trueを返すこと(): void
    {
        $user = new User(
            new Id(1),
            '名前'
        );

        $this->assertTrue($user->equals($user));
    }

    /**
     * equals()
     * @test
     */
    public function 別のUserモデルと比較した場合、falseを返すこと(): void
    {
        $user = new User(
            new Id(1),
            '名前'
        );

        $otherUser = new User(
            new Id(2),
            '別の名前'
        );

        $this->assertFalse($user->equals($otherUser));
    }

    /**
     * equals()
     * @test
     */
    public function nullと比較した場合、falseを返すこと(): void
    {
        $user = new User(
            new Id(1),
            '名前'
        );

        $this->assertFalse($user->equals(null));
    }
}
