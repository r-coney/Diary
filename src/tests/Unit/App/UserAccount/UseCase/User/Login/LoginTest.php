<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Login;

use DateTime;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Models\AccessToken;
use App\UserAccount\Consts\UserConst;
use App\UserAccount\UseCase\User\Login\Login;
use App\UserAccount\UseCase\User\Login\LoginCommand;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use App\UserAccount\Infrastructure\Services\AccessTokenServiceInterface;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;
use RuntimeException;

class LoginTest extends TestCase
{
    private UserRepositoryInterface $userRepository;
    private Encryptor $encryptor;
    private AccessTokenServiceInterface $accessTokenService;
    private Request $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->encryptor = new BcryptEncryptor();
        $this->accessTokenService = $this->createMock(AccessTokenServiceInterface::class);
        $this->request = $this->mock(Request::class);
    }

    /**
     * @test
     */
    public function リクエストのユーザー情報が登録情報と一致する場合、アクセストークンが発行されること(): void
    {
        $email = 'test@example.com';
        $password = new Password('password1');
        $user = new User(
            id: new Id(1),
            name: new Name('test'),
            email: new Email($email),
            password: $password->encrypt($this->encryptor),
            registeredDateTime: new DateTime()
        );

        $this->userRepository->method('findByEmail')->willReturn($user);
        $accessToken = new AccessToken([
            'user_id' => $user->id(),
            'token' => 'token',
            'expires_at' => '5000-12-30 12:00:00',
        ]);
        $this->accessTokenService->method('generate')->willReturn($accessToken);
        if (!$this->setRequestValue(email: $email, password: $password->value())) {
            throw new RuntimeException('Failed to set request value.');
        };

        $command = new LoginCommand($this->request);
        $login = new Login($this->userRepository, $this->encryptor, $this->accessTokenService);

        $result = $login($command);
        $loggedInUserData = $result->value();

        $this->assertSame($accessToken->token, $loggedInUserData->accessToken);
    }

    /**
     * @test
     */
    public function リクエストユーザーが存在しない場合、エラーの結果を返すこと(): void
    {
        $this->userRepository->method('findByEmail')->willReturn(null);
        if (!$this->setRequestValue(email: 'test@example.com', password: 'Password1')) {
            throw new RuntimeException('Failed to set request value.');
        }

        $command = new LoginCommand($this->request);
        $login = new Login($this->userRepository, $this->encryptor, $this->accessTokenService);

        $result = $login($command);

        $this->assertTrue($result->hasError());
    }

    /**
     * @test
     */
    public function パスワードが一致しない場合、エラーの結果を返すこと(): void
    {
        $email = 'test@example.com';
        $password = new Password('password1');
        $user = new User(
            id: new Id(1),
            name: new Name('test'),
            email: new Email($email),
            password: $password->encrypt($this->encryptor),
            registeredDateTime: new DateTime()
        );

        $this->userRepository->method('findByEmail')->willReturn($user);
        if (!$this->setRequestValue(email: $email, password: 'otherPassword1')) {
            throw new RuntimeException('Failed to set request value.');
        }

        $command = new LoginCommand($this->request);
        $login = new Login($this->userRepository, $this->encryptor, $this->accessTokenService);

        $result = $login($command);

        $this->assertTrue($result->hasError());
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
