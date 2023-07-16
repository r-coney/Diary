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
        $this->request->shouldReceive('input')
            ->andReturnUsing(function ($inputName) {
                if ($inputName === 'user_id') {
                    return $this->registeredUser->id();
                } elseif ($inputName === 'access_token') {
                    return $this->accessToken->token;
                }
            });

        $verifyTokenCommand = new VerifyTokenCommand($this->request);
        $verifyAccessToken = new VerifyAccessToken($this->userRepository, $this->accessTokenRepository, $this->accessTokenService);

        $this->assertTrue($verifyAccessToken($verifyTokenCommand));
    }

    /**
     * @test
     */
    public function 存在しないユーザーIDとアクセストークンがリクエストされた場合、例外を投げること(): void
    {
        $this->request->shouldReceive('input')
        ->andReturnUsing(function ($inputName) {
            if ($inputName === 'user_id') {
                // 存在しないユーザーを指定したいため、あり得ない数値にする
                return 999999999;
            } elseif ($inputName === 'access_token') {
                return $this->accessToken->token;
            }
        });

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
        $this->request->shouldReceive('input')
        ->andReturnUsing(function ($inputName) {
            if ($inputName === 'user_id') {
                return $this->registeredUser->id();
            } elseif ($inputName === 'access_token') {
                // 保存されていないトークンにしたいため、適当な文字列
                return 'unsaved token';
            }
        });

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
        $this->request->shouldReceive('input')
            ->andReturnUsing(function ($inputName) {
                if ($inputName === 'user_id') {
                    return $this->registeredUser->id();
                } elseif ($inputName === 'access_token') {
                    return $this->accessToken->token;
                }
            });

        $this->expectException(AuthenticationException::class);
        $verifyTokenCommand = new VerifyTokenCommand($this->request);
        $verifyAccessToken = new VerifyAccessToken($this->userRepository, $this->accessTokenRepository, $this->accessTokenService);
        $verifyAccessToken($verifyTokenCommand);
    }
}
