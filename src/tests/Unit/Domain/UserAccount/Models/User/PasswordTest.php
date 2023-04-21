<?php

namespace Tests\Unit\Domain\UserAccount\Models\User;

use Tests\TestCase;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Exceptions\User\InvalidPasswordException;

class PasswordTest extends TestCase
{
    /**
     * @test
     */
    public function パスワードに全角文字が含まれている場合に例外が発生すること()
    {
        $this->expectException(InvalidPasswordException::class);
        $this->expectExceptionMessage('パスワードに全角文字が含まれています');
        new Password('Abc１２３４');
    }

    /**
     * @test
     */
    public function パスワードに数字と小文字が含まれていない場合に例外が発生すること()
    {
        $this->expectException(InvalidPasswordException::class);
        $this->expectExceptionMessage('パスワードには数字と小文字を含めてください');
        new Password('ABCD');
    }

    /**
     * @test
     */
    public function パスワードが8文字未満の場合に例外が発生すること()
    {
        $this->expectException(InvalidPasswordException::class);
        $this->expectExceptionMessage('パスワードは8文字以上で入力してください');
        new Password('Abc1234');
    }

    /**
     * @test
     */
    public function パスワードをハッシュ化できること()
    {
        $password = new Password('Abcd1234');
        $encryptor = $this->createMock(Encryptor::class);
        $encryptor->expects($this->once())
            ->method('encrypt')
            ->with('Abcd1234')
            ->willReturn('encrypted_password');

        $encryptedPassword = $password->encrypt($encryptor);
        $this->assertSame('encrypted_password', $encryptedPassword->value());
    }

    /**
     * @test
     */
    public function 同じパスワード値を持つオブジェクト同士は等価であること()
    {
        $password1 = new Password('Abcd1234');
        $password2 = new Password('Abcd1234');
        $this->assertTrue($password1->equals($password2));
    }

    /**
     * @test
     */
    public function 異なるパスワード値を持つオブジェクト同士は等価ではないこと()
    {
        $password1 = new Password('Abcd1234');
        $password2 = new Password('Def56789');
        $this->assertFalse($password1->equals($password2));
    }

    /**
     * @test
     */
    public function nullを渡した場合は等価ではないこと()
    {
        $password = new Password('Abcd1234');
        $this->assertFalse($password->equals(null));
    }

    /**
     * @test
     */
    public function 同じオブジェクト同士は等価であること()
    {
        $password = new Password('Abcd1234');
        $this->assertTrue($password->equals($password));
    }
}
