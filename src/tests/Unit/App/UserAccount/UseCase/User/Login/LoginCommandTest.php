<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Login;

use App\UserAccount\UseCase\User\Login\LoginCommand;
use PHPUnit\Framework\TestCase;

class LoginCommandTest extends TestCase
{
    /**
     * email()
     * @test
     */
    public function メールアドレスを取得できること(): void
    {
        $email = 'test@example.com';
        $command = new LoginCommand($email, 'password1');

        $this->assertSame($email, $command->email());
    }

    /**
     * password
     * @test
     */
    public function パスワードを取得できること(): void
    {
        $password = 'password1';
        $command = new LoginCommand('test@example.com', $password);

        $this->assertSame($password, $command->password());
    }
}
