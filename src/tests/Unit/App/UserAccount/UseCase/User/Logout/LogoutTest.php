<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Logout;

use DateTime;
use Tests\TestCase;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\UserAccount\User\UseCase\UserNotFoundException;
use App\UserAccount\Infrastructure\AccessTokenRepositoryInterface;
use App\UserAccount\Infrastructure\Test\Repositories\UserRepository;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use App\UserAccount\Infrastructure\Test\Repositories\AccessTokenRepository;
use App\UserAccount\UseCase\User\Logout\LogoutCommand;
use App\UserAccount\UseCase\User\Logout\Logout;
use App\Models\AccessToken;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Id as UserId;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\EncryptedPassword;
use Domain\UserAccount\Models\User\InMemoryFactory;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class LogoutTest extends TestCase
{
    private LogoutCommand $logoutCommand;
    private UserRepositoryInterface $userRepository;
    private User $loggedInUser;
    private AccessTokenRepositoryInterface $accessTokenRepository;
    private AccessToken $accessToken;

    public function setUp(): void
    {
        parent::setUp();
        $this->logoutCommand = $this->mock(LogoutCommand::class);
        $this->userRepository = new UserRepository(new InMemoryFactory(new BcryptEncryptor()));
        $this->loggedInUser = new User(
            id: new UserId(1),
            name: new Name('test'),
            email: new Email('test@example.com'),
            password: new EncryptedPassword('password1'),
            registeredDateTime: new DateTime()
        );
        $this->userRepository->save($this->loggedInUser);
        $this->accessTokenRepository = new AccessTokenRepository();
        $this->accessToken = $this->accessTokenRepository->save(new AccessToken([
            'user_id' => $this->loggedInUser->id(),
            'token' => 'token',
            'expires_at' => date('Y-m-d', strtotime('+1 day')),
        ]));
    }

    /**
     * @test
     */
    public function ログインしているユーザーのアクセストークンが削除されること(): void
    {
        if (!$this->setLogoutCommandReturnValue(new UserId($this->loggedInUser->id()))) {
            throw new InvalidArgumentException();
        }

        $logout = new Logout($this->userRepository, $this->accessTokenRepository);

        $this->assertTrue($logout($this->logoutCommand));
        $this->assertNull($this->accessTokenRepository->findByUserId(new UserId($this->loggedInUser->id())));
    }

    /**
     * @test
     */
    public function 存在しないユーザーIDが指定された場合、例外を投げること(): void
    {
        // 設定していないユーザーのIDを指定
        if (!$this->setLogoutCommandReturnValue(new UserId(99999999))) {
            throw new InvalidArgumentException();
        }

        $logout = new Logout($this->userRepository, $this->accessTokenRepository);

        $this->expectException(UserNotFoundException::class);
        $logout($this->logoutCommand);
    }

    /**
     * @test
     */
    public function ユーザーIDが指定されたされなかった場合、例外を投げること(): void
    {
        if (!$this->setLogoutCommandReturnValue(null)) {
            throw new InvalidArgumentException();
        }

        $logout = new Logout($this->userRepository, $this->accessTokenRepository);

        $this->expectException(NotFoundHttpException::class);
        $logout($this->logoutCommand);
    }

    /**
     * @test
     */
    public function アクセストークンが存在しない場合、trueを返すこと(): void
    {
        if (!$this->accessTokenRepository->delete($this->accessToken)) {
            throw new RuntimeException();
        };

        if (!$this->setLogoutCommandReturnValue(new UserId($this->loggedInUser->id()))) {
            throw new InvalidArgumentException();
        }

        $logout = new Logout($this->userRepository, $this->accessTokenRepository);

        $this->assertTrue($logout($this->logoutCommand));
    }

    private function setLogoutCommandReturnValue(?UserId $userId): bool
    {
        $this->logoutCommand->shouldReceive('userId')
            ->andReturn($userId?->value());

        $this->logoutCommand->shouldReceive('hasUserId')
            ->andReturnUsing(function () use ($userId) {
                return $userId?->value() !== null;
            });

        if ($this->logoutCommand->userId() !== $userId?->value() || $this->logoutCommand->hasUserId() !== isset($userId)) {
            return false;
        }

        return true;
    }
}
