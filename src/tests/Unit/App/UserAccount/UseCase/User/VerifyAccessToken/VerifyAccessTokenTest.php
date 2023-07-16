<?php
namespace Tests\Unit\App\UserAccount\UseCase\User\VerifyAccessToken;

use Tests\TestCase;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Models\AccessToken;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use App\UserAccount\Infrastructure\Services\AccessTokenService;
use App\UserAccount\Infrastructure\Services\AccessTokenServiceInterface;
use App\UserAccount\Infrastructure\Test\Repositories\AccessTokenRepository;
use App\UserAccount\Infrastructure\Test\Repositories\UserRepository;
use App\UserAccount\UseCase\User\VerifyAccessToken\VerifyAccessToken;
use App\UserAccount\UseCase\User\VerifyAccessToken\VerifyTokenCommand;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\EncryptedPassword;
use Domain\UserAccount\Models\User\InMemoryFactory;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class VerifyAccessTokenTest extends TestCase
{
    private Request $request;
    private User $registeredUser;
    private UserRepositoryInterface $userRepository;
    private AccessToken $accessToken;
    private AccessTokenRepository $accessTokenRepository;
    private AccessTokenServiceInterface $accessTokenService;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = $this->mock(Request::class);

        $this->registeredUser = new User (
            id: new Id(1),
            name: new Name('test'),
            email: new Email('test@example.com'),
            password: new EncryptedPassword('password1'),
            registeredDateTime: new DateTime()
        );
        $this->userRepository = new UserRepository(new InMemoryFactory(new BcryptEncryptor()));
        $this->userRepository->save($this->registeredUser);

        $this->accessToken = new AccessToken([
            'user_id' => $this->registeredUser->id(),
            'token' => 'test',
            'expires_at' => date('Y-m-d', strtotime('+1 day')),
        ]);
        $this->accessTokenRepository = new AccessTokenRepository();
        $this->accessTokenRepository->save($this->accessToken);
        $this->accessTokenService = new AccessTokenService($this->accessTokenRepository);
    }

    /**
     * @test
     */
    public function 有効なユーザーIDとアクセストークンがリクエストされた場合、trueを返すこと(): void
    {
        if (!$this->setRequestValue(userId: $this->registeredUser->id(), token: $this->accessToken->token)) {
            exit;
        }
        $verifyTokenCommand = new VerifyTokenCommand($this->request);
        $verifyAccessToken = new VerifyAccessToken($this->userRepository, $this->accessTokenRepository, $this->accessTokenService);

        $this->assertTrue($verifyAccessToken($verifyTokenCommand));
    }

    /**
     * @test
     */
    public function 存在しないユーザーIDとアクセストークンがリクエストされた場合、例外を投げること(): void
    {
        if (!$this->setRequestValue(userId: 9999999, token: $this->accessToken->token)) {
            exit;
        }
        $this->expectException(AuthenticationException::class);
        $verifyTokenCommand = new VerifyTokenCommand($this->request);
        $verifyAccessToken = new VerifyAccessToken($this->userRepository, $this->accessTokenRepository, $this->accessTokenService);
        $verifyAccessToken($verifyTokenCommand);
    }

    /**
     * @test
     */
    public function 有効なユーザーIDと存在しないアクセストークンがリクエストされた場合、例外を投げること(): void
    {
        if (!$this->setRequestValue(userId: $this->registeredUser->id(), token: 'unsaved token')) {
            exit;
        }
        $this->expectException(AuthenticationException::class);
        $verifyTokenCommand = new VerifyTokenCommand($this->request);
        $verifyAccessToken = new VerifyAccessToken($this->userRepository, $this->accessTokenRepository, $this->accessTokenService);
        $verifyAccessToken($verifyTokenCommand);
    }

    /**
     * @test
     */
    public function 有効なユーザーIDとアクセストークンがリクエストされが、トークンの有効期限が切れている場合、例外を投げること(): void
    {
        $this->accessToken->expires_at = date('Y-m-d', strtotime('-1 day'));
        $this->accessTokenRepository->save($this->accessToken);
        if (!$this->setRequestValue($this->registeredUser->id(), $this->accessToken->token)) {
            exit;
        }
        $this->expectException(AuthenticationException::class);
        $verifyTokenCommand = new VerifyTokenCommand($this->request);
        $verifyAccessToken = new VerifyAccessToken($this->userRepository, $this->accessTokenRepository, $this->accessTokenService);
        $verifyAccessToken($verifyTokenCommand);
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
