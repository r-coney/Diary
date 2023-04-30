<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Register;

use DateTime;
use Tests\TestCase;
use App\UserAccount\UseCase\User\Register\Register;
use App\UserAccount\UseCase\User\Register\RegisterCommand;
use App\UserAccount\Infrastructure\Test\Repositories\UserRepository;
use App\Exceptions\UserAccount\User\UseCase\CanNotRegisterUserException;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Services\UserService;
use Domain\UserAccount\Models\User\EncryptedPassword;
use Domain\UserAccount\Models\User\InMemoryFactory as InMemoryUserFactory;
use Domain\UserAccount\Models\User\FactoryInterface as UserFactoryInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class RegisterTest extends TestCase
{
    private UserFactoryInterface $userFactory;
    private UserRepositoryInterface $userRepository;
    private UserService $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = new InMemoryUserFactory();
        $this->userRepository = new UserRepository($this->userFactory);
        $this->userService = new UserService($this->userRepository);
    }

    /**
     * @test
     */
    public function ユーザーを新規登録できること(): void
    {
        $command = new RegisterCommand('テスト', 'test@example.com', 'password1', 'password1');
        $register = new Register($this->userFactory, $this->userService, $this->userRepository);

        $register($command);
        $registeredUser = $this->userRepository->findByEmail(new Email($command->email()));

        $this->assertSame($command->name(), $registeredUser->name());
        $this->assertSame($command->email(), $registeredUser->email());
    }

    /**
     * @test
     */
    public function パスワードと確認用パスワードが一致しない場合、登録に失敗すること(): void
    {
        $this->expectException(CanNotRegisterUserException::class);

        $command = new RegisterCommand('テスト', 'test@example.com', 'password1', 'password2');
        $register = new Register($this->userFactory, $this->userService, $this->userRepository);
        $register($command);
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

        $command = new RegisterCommand($user->name(), $user->email(), 'password1', 'password1');
        $register = new Register($this->userFactory, $this->userService, $this->userRepository);
        $register($command);
    }
}
