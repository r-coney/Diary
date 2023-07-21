<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Register;

use DateTime;
use Tests\TestCase;
use App\UserAccount\UseCase\User\Register\Register;
use App\UserAccount\UseCase\User\Register\RegisterCommand;
use App\UserAccount\Infrastructure\InMemory\Repositories\UserRepository;
use App\Exceptions\UserAccount\User\UseCase\CanNotRegisterUserException;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Services\UserService;
use Domain\UserAccount\Models\User\EncryptedPassword;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Models\User\InMemoryFactory as InMemoryUserFactory;
use Domain\UserAccount\Models\User\FactoryInterface as UserFactoryInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class RegisterTest extends TestCase
{
    private UserFactoryInterface $userFactory;
    private UserRepositoryInterface $userRepository;
    private UserService $userService;
    private Encryptor $encryptor;
    private RegisterCommand $registerCommand;

    public function setUp(): void
    {
        parent::setUp();
        $this->encryptor = new BcryptEncryptor();
        $this->userFactory = new InMemoryUserFactory($this->encryptor);
        $this->userRepository = new UserRepository($this->userFactory);
        $this->userService = new UserService($this->userRepository);
        $this->registerCommand = $this->mock(RegisterCommand::class);
    }

    /**
     * @test
     */
    public function ユーザーを新規登録できること(): void
    {
        $this->setRegisterCommandReturnValue(
            name: 'test',
            email: 'test@example.com',
            password: 'password1',
            passwordConfirmation: 'password1'
        );
        $register = new Register($this->userFactory, $this->userService, $this->userRepository);
        $register($this->registerCommand);

        $registeredUser = $this->userRepository->findByEmail(new Email($this->registerCommand->email()));

        $this->assertSame($this->registerCommand->name(), $registeredUser->name());
        $this->assertSame($this->registerCommand->email(), $registeredUser->email());
    }

        /**
     * @test
     */
    public function 登録したユーザーを返すこと(): void
    {
        $this->setRegisterCommandReturnValue(
            name: 'test',
            email: 'test@example.com',
            password: 'password1',
            passwordConfirmation: 'password1'
        );
        $register = new Register($this->userFactory, $this->userService, $this->userRepository);
        $registeredUser = $register($this->registerCommand);

        $this->assertSame($this->registerCommand->name(), $registeredUser->name());
        $this->assertSame($this->registerCommand->email(), $registeredUser->email());
    }

    /**
     * @test
     */
    public function パスワードと確認用パスワードが一致しない場合、登録に失敗すること(): void
    {
        $this->expectException(CanNotRegisterUserException::class);

        $this->setRegisterCommandReturnValue(
            name: 'test',
            email: 'test@example.com',
            password: 'password1',
            passwordConfirmation: 'password2'
        );
        $register = new Register($this->userFactory, $this->userService, $this->userRepository);
        $register($this->registerCommand);
    }

    /**
     * @test
     */
    public function すでに使用されたメールアドレスでユーザー登録した場合、登録に失敗すること(): void
    {
        $this->expectException(CanNotRegisterUserException::class);

        $user = new User(
            new Id(1),
            new Name('テスト'),
            new Email('test@example.com'),
            new EncryptedPassword('password1'),
            new DateTime()
        );

        $this->userRepository->save($user);
        $this->setRegisterCommandReturnValue(
            name: $user->name(),
            email: $user->email(),
            password: $user->password(),
            passwordConfirmation: $user->password()
        );
        $register = new Register($this->userFactory, $this->userService, $this->userRepository);
        $register($this->registerCommand);
    }

    /**
     * RegisterCommandの返り値を設定
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     * @return void
     */
    private function setRegisterCommandReturnValue(
        string $name,
        string $email,
        string $password,
        string $passwordConfirmation
    ): void {
        $this->registerCommand->shouldReceive('name')
            ->andReturn($name);

        $this->registerCommand->shouldReceive('email')
            ->andReturn($email);

        $this->registerCommand->shouldReceive('password')
            ->andReturn($password);

        $this->registerCommand->shouldReceive('passwordConfirmation')
            ->andReturn($passwordConfirmation);
    }
}
