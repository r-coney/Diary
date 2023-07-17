<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Logout;

use App\UserAccount\UseCase\User\Logout\LogoutCommand;
use Database\Seeders\InMemory\Reset;
use DateTime;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\EncryptedPassword;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Tests\TestCase;

class LogoutCommandTest extends TestCase
{
    private User $loggedInUser;
    private Request $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->loggedInUser = new User(
            id: new Id(1),
            name: new Name('test'),
            email: new Email('test@example.com'),
            password: new EncryptedPassword('password1'),
            registeredDateTime: new DateTime()
        );
        $this->request = $this->mock(Request::class);
    }

    /**
     * @test
     * userId()
     */
    public function ユーザーIDを取得できること(): void
    {
        if (!$this->setRequestValue($this->loggedInUser->id())) {
            throw new InvalidArgumentException();
        }
        $logoutCommand = new LogoutCommand($this->request);

        $this->assertSame($this->loggedInUser->id(), $logoutCommand->userId());
    }

    /**
     * @test
     * userId()
     */
    public function ユーザーIDが存在しない場合nullを返すこと(): void
    {
        if (!$this->setRequestValue(null)) {
            throw new InvalidArgumentException();
        }
        $logoutCommand = new LogoutCommand($this->request);

        $this->assertSame(null, $logoutCommand->userId());
    }

    /**
     * @test
     * hasUserId()
     */
    public function ユーザーIDが存在する場合trueを返すこと(): void
    {
        if (!$this->setRequestValue($this->loggedInUser->id())) {
            throw new InvalidArgumentException();
        }
        $logoutCommand = new LogoutCommand($this->request);

        $this->assertTrue($logoutCommand->hasUserId());
    }

    /**
     * @test
     * hasUserId()
     */
    public function ユーザーIDが存在しない場合falseを返すこと(): void
    {
        if (!$this->setRequestValue(null)) {
            throw new InvalidArgumentException();
        }
        $logoutCommand = new LogoutCommand($this->request);

        $this->assertFalse($logoutCommand->hasUserId());
    }

    private function setRequestValue(?int $userId): bool
    {
        $this->request->shouldReceive('input')
            ->with('user_id')
            ->andReturn($userId);

        if ($this->request->input('user_id') !== $userId) {
            return false;
        }

        return true;
    }
}
