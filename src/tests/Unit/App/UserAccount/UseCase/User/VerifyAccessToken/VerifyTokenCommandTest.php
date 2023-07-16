<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\VerifyAccessToken;

use DateTime;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Models\AccessToken;
use App\UserAccount\UseCase\User\VerifyAccessToken\VerifyTokenCommand;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\EncryptedPassword;

class VerifyTokenCommandTest extends TestCase
{
    private Request $request;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = $this->mock(Request::class);
        $this->user = new User(
            id: new Id(1),
            name: new Name('test'),
            email: new Email('test@example.com'),
            password: new EncryptedPassword('password1'),
            registeredDateTime: new DateTime()
        );
    }

    /**
     * @test
     */
    public function ユーザーID、トークンを取得できること(): void
    {
        $accessToken = new AccessToken([
            'user_id' => $this->user->id(),
            'token' => 'token',
            'expires_at' => date('Y-m-d h:i:s'),
        ]);

        if (!$this->setRequestValue(userId: $this->user->id(), token: $accessToken->token)) {
            exit;
        }
        $verifyTokenCommand = new VerifyTokenCommand($this->request);

        $this->assertSame($this->user->id(), $verifyTokenCommand->userId());
        $this->assertSame($accessToken->token, $verifyTokenCommand->accessToken());
    }

    /**
     * @test
     */
    public function ユーザーID、トークンがリクエストに含まれていない場合nullを返すこと(): void
    {
        if (!$this->setRequestValue(userId: null, token: null)) {
            exit;
        }

        $verifyTokenCommand = new VerifyTokenCommand($this->request);

        $this->assertNull($verifyTokenCommand->userId());
        $this->assertNull($verifyTokenCommand->accessToken());
    }

    private function setRequestValue(?int $userId, ?string $token): bool
    {
        $this->request->shouldReceive('input')
            ->with('user_id')
            ->andReturn($userId);

        $this->request->shouldReceive('bearerToken')
            ->andReturn($token);

        if ($this->request->input('user_id') !== $userId || $this->request->bearerToken() !== $token) {
            return false;
        }

        return true;
    }
}
