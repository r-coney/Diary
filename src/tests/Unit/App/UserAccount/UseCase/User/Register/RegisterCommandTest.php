<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Register;

use Tests\TestCase;
use App\UserAccount\UseCase\User\Register\RegisterCommand;

class RegisterCommandTest extends TestCase
{
    /**
     * name()
     * @test
     */
    public function 名前を取得できる(): void
    {
        $name = 'テスト';
        $command = new RegisterCommand($name, 'test@example.com', 'password', 'password');

        $this->assertSame($name, $command->name());
    }

    /**
     * email()
     * @test
     */
    public function メールアドレスを取得できる(): void
    {
        $email = 'test@example.com';
        $command = new RegisterCommand('テスト', $email, 'password', 'password');

        $this->assertSame($email, $command->email());
    }

    /**
     * password()
     * @test
     */
    public function パスワードを取得できる(): void
    {
        $password = 'password';
        $command = new RegisterCommand('テスト', 'test@example.com', $password, 'password');

        $this->assertSame($password, $command->password());
    }

    /**
     * passwordConfirmation()
     * @test
     */
    public function パスワード確認用の値を取得できる(): void
    {
        $passwordConfirmation = 'password';
        $command = new RegisterCommand('テスト', 'test@example.com', 'password', $passwordConfirmation);

        $this->assertSame($passwordConfirmation, $command->passwordConfirmation());
    }
}
