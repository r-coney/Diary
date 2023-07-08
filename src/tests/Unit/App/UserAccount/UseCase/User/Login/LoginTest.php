<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Login;

use DateTime;
use Tests\TestCase;
use App\Models\AccessToken;
use App\UserAccount\UseCase\User\Login\Login;
use App\UserAccount\UseCase\User\Login\LoginCommand;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use App\UserAccount\Infrastructure\Services\AccessTokenServiceInterface;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class LoginTest extends TestCase
{
    private UserRepositoryInterface $userRepository;
    private Encryptor $encryptor;
    private AccessTokenServiceInterface $accessTokenService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->encryptor = new BcryptEncryptor();
        $this->accessTokenService = $this->createMock(AccessTokenServiceInterface::class);
    }

    /**
     * @test
     */
    public function リクエストのユーザー情報が登録情報と一致する場合、アクセストークンが発行されること(): void
    {
        $email = 'test@example.com';
        $password = new Password('password1');
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email($email),
            $password->encrypt($this->encryptor),
            new DateTime()
        );

        $this->userRepository->method('findByEmail')->willReturn($user);
        $accessToken = new AccessToken([
            'user_id' => $user->id(),
            'token' => 'token',
            'expires_at' => '5000-12-30 12:00:00',
        ]);
        $this->accessTokenService->method('generate')->willReturn($accessToken);
        $command = new LoginCommand($email, $password->value());
        $login = new Login($this->userRepository, $this->encryptor, $this->accessTokenService);

        $response = $login($command);

        $this->assertSame($accessToken->token, $response['access_token']);
    }

    /**
     * @test
     */
    public function リクエストユーザーが存在しない場合、エラーのレスポンスを返すこと(): void
    {
        $this->userRepository->method('findByEmail')->willReturn(null);
        $command = new LoginCommand('test@example.com', 'password');
        $login = new Login($this->userRepository, $this->encryptor, $this->accessTokenService);

        $response = $login($command);

        $this->assertSame('error', $response['status']);
    }

    /**
     * @test
     */
    public function パスワードが一致しない場合、エラーのレスポンスを返すこと(): void
    {
        $email = 'test@example.com';
        $password = new Password('password1');
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email($email),
            $password->encrypt($this->encryptor),
            new DateTime()
        );

        $this->userRepository->method('findByEmail')->willReturn($user);
        $command = new LoginCommand($email, 'otherPassword');
        $login = new Login($this->userRepository, $this->encryptor, $this->accessTokenService);

        $response = $login($command);

        $this->assertSame('error', $response['status']);
    }
}
