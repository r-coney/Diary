<?php
namespace Tests\Unit\App\UserAccount\UseCase\User\Register;

use Tests\TestCase;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\UserAccount\Consts\UserConst;
use App\UserAccount\UseCase\User\Register\RegisterCommand;

class RegisterCommandTest extends TestCase
{
    private Request $request;

    /**
     * name()
     * @test
     */
    public function 名前を取得できる(): void
    {
        $this->setRequestValue(
            name: 'test',
            email: 'test@example.com',
            password: 'password',
            passwordConfirmation: 'password'
        );
        $command = new RegisterCommand($this->request);

        $this->assertSame($this->request->input(UserConst::INPUT_NAME), $command->name());
    }

    /**
     * email()
     * @test
     */
    public function メールアドレスを取得できる(): void
    {
        $this->setRequestValue(
            name: 'test',
            email: 'test@example.com',
            password: 'password',
            passwordConfirmation: 'password'
        );
        $command = new RegisterCommand($this->request);

        $this->assertSame($this->request->input(UserConst::INPUT_EMAIL), $command->email());
    }

    /**
     * password()
     * @test
     */
    public function パスワードを取得できる(): void
    {
        $this->setRequestValue(
            name: 'test',
            email: 'test@example.com',
            password: 'password',
            passwordConfirmation: 'password'
        );
        $command = new RegisterCommand($this->request);

        $this->assertSame($this->request->input(UserConst::INPUT_PASSWORD), $command->password());
    }

    /**
     * passwordConfirmation()
     * @test
     */
    public function パスワード確認用の値を取得できる(): void
    {
        $this->setRequestValue(
            name: 'test',
            email: 'test@example.com',
            password: 'password',
            passwordConfirmation: 'password'
        );
        $command = new RegisterCommand($this->request);

        $this->assertSame($this->request->input(UserConst::INPUT_PASSWORD_CONFIRMATION), $command->passwordConfirmation());
    }

    /**
     * リクエストクラスのモックに値をセット
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     * @return void
     */
    private function setRequestValue(
        string $name,
        string $email,
        string $password,
        string $passwordConfirmation
    ): void {
        $this->request = $this->mock(Request::class);
        $this->request->shouldReceive('input')
            ->andReturnUsing(function ($inputName) use ($name, $email, $password, $passwordConfirmation) {
                switch ($inputName) {
                    case UserConst::INPUT_NAME:
                        return $name;
                    case UserConst::INPUT_EMAIL:
                        return $email;
                    case UserConst::INPUT_PASSWORD;
                        return $password;
                    case UserConst::INPUT_PASSWORD_CONFIRMATION;
                        return $passwordConfirmation;
                    default:
                        throw new InvalidArgumentException($inputName . 'not found.');
                }
            });
    }
}
