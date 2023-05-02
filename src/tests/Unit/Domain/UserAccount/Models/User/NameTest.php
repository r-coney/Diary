<?php

namespace Tests\Unit\Domain\UserAccount\Models\User;

use PHPUnit\Framework\TestCase;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Exceptions\User\InvalidNameException;

class NameTest extends TestCase
{
    /**
     * @test
     */
    public function 名前が800文字を超えている場合、例外がスローされること()
    {
        $this->expectException(InvalidNameException::class);
        new Name(str_repeat('a', 801));
    }

    /**
     * @test
     */
    public function 名前が空の場合、例外がスローされること()
    {
        $this->expectException(InvalidNameException::class);
        new Name('');
    }

    /**
     * @test
     */
    public function 名前が800文字以内の場合、インスタンスが正常に作成されること()
    {
        $name = 'テストユーザー';
        $nameInstance = new Name($name);

        $this->assertInstanceOf(Name::class, $nameInstance);
        $this->assertEquals($name, $nameInstance->value());
    }

    /**
     * @test
     */
    public function 同じ名前のインスタンスを比較する場合、trueが返ること()
    {
        $name1 = new Name('テストユーザー');
        $name2 = new Name('テストユーザー');

        $this->assertTrue($name1->equals($name2));
    }

    /**
     * @test
     */
    public function 異なる名前のインスタンスを比較する場合、falseが返ること()
    {
        $name1 = new Name('テストユーザー');
        $name2 = new Name('別のユーザー');

        $this->assertFalse($name1->equals($name2));
    }

    /**
     * @test
     */
    public function nullと比較する場合、falseが返ること()
    {
        $name = new Name('テストユーザー');

        $this->assertFalse($name->equals(null));
    }
}
