<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Login;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\UserAccount\Consts\UserConst;
use App\UserAccount\UseCase\User\Login\LoginCommand;
use RuntimeException;

class LoginCommandTest extends TestCase
{
    private Request $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = $this->mock(Request::class);
    }

    /**
     * email()
     * @test
     */
    public function メールアドレスを取得できること(): void
    {
        if (!$this->setRequestValue('test@example.com', 'Password1')) {
            throw new RuntimeException('Failed to set request value.');
        }

        $command = new LoginCommand($this->request);

        $this->assertSame($this->request->input(UserConst::INPUT_EMAIL), $command->email());
    }

    /**
     * password
     * @test
     */
    public function パスワードを取得できること(): void
    {
        if (!$this->setRequestValue('test@example.com', 'Password1')) {
            throw new RuntimeException('Failed to set request value.');
        }

        $command = new LoginCommand($this->request);

        $this->assertSame($this->request->input(UserConst::INPUT_PASSWORD), $command->password());
    }

    /**
     * Requestの返り値を設定
     *
     * @param string|null $email
     * @param string|null $password
     * @return bool
     */
    private function setRequestValue(?string $email, ?string $password): bool
    {
        $this->request->shouldReceive('input')
            ->with(UserConst::INPUT_EMAIL)
            ->andReturn($email);

        $this->request->shouldReceive('input')
            ->with(UserConst::INPUT_PASSWORD)
            ->andReturn($password);

        if ($this->request->input(UserConst::INPUT_EMAIL) !== $email) {
            return false;
        }
        if ($this->request->input(UserConst::INPUT_PASSWORD) !== $password) {
            return false;
        }

        return true;
    }
}
