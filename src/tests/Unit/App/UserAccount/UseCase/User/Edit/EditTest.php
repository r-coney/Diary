<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Edit;

use App\Exceptions\UserAccount\User\UseCase\CanNotEditUserException;
use DateTime;
use Tests\TestCase;
use App\UserAccount\UseCase\User\Edit\Edit;
use App\UserAccount\UseCase\User\Edit\EditCommand;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use App\UserAccount\Infrastructure\InMemory\Repositories\UserRepository;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Models\User\InMemoryFactory;
use Domain\UserAccount\Models\User\FactoryInterface as UserFactoryInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class EditTest extends TestCase
{
    private UserFactoryInterface $userFactory;
    private UserRepositoryInterface $userRepository;
    private Encryptor $encryptor;

    public function setUp(): void
    {
        parent::setUp();

        $this->encryptor = new BcryptEncryptor();
        $this->userFactory = new InMemoryFactory($this->encryptor);
        $this->userRepository = new UserRepository($this->userFactory);
    }

    /**
     * @test
     */
    public function ユーザー情報を編集できること(): void
    {
        $currentPassword = 'password1';
        $user = $this->userFactory->create(
            new Name('テスト'),
            new Email('test@example.com'),
            new Password($currentPassword),
            new DateTime()
        );

        $this->userRepository->save($user);

        $editCommand = new EditCommand(
            $user->id(),
            '編集後の名前',
            'editedMail@example.com',
            'editedPassword1',
            'editedPassword1',
            $currentPassword
        );
        $edit = new Edit($this->userRepository, $this->encryptor);
        $edit($editCommand);

        $editedUser = $this->userRepository->find(new Id($user->id()));
        $this->assertSame($editCommand->newName(), $editedUser->name());
        $this->assertSame($editCommand->newEmail(), $editedUser->email());
        $this->assertTrue($editedUser->verifyPassword($this->encryptor, new Password($editCommand->newPassword())));
    }

    /**
     * @test
     */
    public function パスワードが一致しない場合、ユーザーの編集に失敗すること(): void
    {
        $this->expectException(CanNotEditUserException::class);

        $user = $this->userFactory->create(
            new Name('テスト'),
            new Email('test@example.com'),
            new Password('password1'),
            new DateTime()
        );

        $this->userRepository->save($user);

        $editCommand = new EditCommand(
            $user->id(),
            '編集後の名前',
            'editedMail@example.com',
            'editedPassword1',
            'editedPassword1',
            'password2'
        );
        $edit = new Edit($this->userRepository, $this->encryptor);
        $edit($editCommand);
    }
}
