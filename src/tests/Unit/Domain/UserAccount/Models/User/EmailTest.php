<?php

namespace Tests\Unit\Domain\UserAccount\Models\User;

use Tests\TestCase;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Exceptions\User\InvalidEmailException;

class EmailTest extends TestCase
{
    /**
     * @test
     */
    public function メールアドレスが255文字以上の場合、例外を投げること()
    {
        $tooLongEmail = str_repeat('a', 256);
        $this->expectException(InvalidEmailException::class);
        $email = new Email($tooLongEmail);
    }

    /**
     * @test
     */
    public function メールアドレスが無効な場合、例外を投げること()
    {
        $invalidEmail = 'invalidEmail';
        $this->expectException(InvalidEmailException::class);
        $email = new Email($invalidEmail);
    }

    /**
     * @test
     */
    public function メールアドレスが正常な場合、Emailを作成できること()
    {
        $validEmail = 'test@example.com';
        $email = new Email($validEmail);
        $this->assertEquals($validEmail, $email->value());
    }

    /**
     * equals()
     * @test
     */
    public function ２つのメールアドレスが等しいかどうかを確認する()
    {
        $email1 = new Email('test@example.com');
        $email2 = new Email('test@example.com');
        $email3 = new Email('other@example.com');
        $this->assertTrue($email1->equals($email2));
        $this->assertFalse($email1->equals($email3));
        $this->assertFalse($email1->equals(null));
    }
}
