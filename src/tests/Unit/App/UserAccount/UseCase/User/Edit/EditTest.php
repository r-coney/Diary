<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Edit;

use Tests\TestCase;
use DateTime;
use RuntimeException;
use Illuminate\Http\Request;
use App\UserAccount\Consts\UserConst;
use App\UserAccount\UseCase\User\Edit\EditCommand;
use App\UserAccount\UseCase\User\Edit\Edit;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use App\Exceptions\UserAccount\User\UseCase\CanNotEditUserException;
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
    private Request $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->encryptor = new BcryptEncryptor();
        $this->userFactory = new InMemoryFactory($this->encryptor);
        $this->userRepository = new UserRepository($this->userFactory);
        $this->request = $this->mock(Request::class);

        // エンコード前のパスワードを保持しておく
        $this->currentPassword = 'Password1';
        $this->user = $this->userFactory->create(
            new Name('テスト'),
            new Email('test@example.com'),
            new Password($this->currentPassword),
            new DateTime()
        );

        $this->userRepository->save($this->user);
    }

    /**
     * @test
     */
    public function ユーザー情報を編集できること(): void
    {
        if (!$this->setRequestValue(
            name: 'edited name',
            email: 'edited@example.com',
            password: 'editedPassword1',
            passwordConfirmation: 'editedPassword1',
            currentPassword: $this->currentPassword,
        )) {
            throw new RuntimeException();
        };

        $editCommand = new EditCommand($this->user->id(), $this->request);
        $edit = new Edit($this->userRepository, $this->encryptor);
        $edit($editCommand);

        $editedUser = $this->userRepository->find(new Id($this->user->id()));
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

        if (!$this->setRequestValue(
            name: 'edited name',
            email: 'edited@example.com',
            password: 'editedPassword1',
            passwordConfirmation: 'editedPassword1',
            currentPassword: 'otherPassword1'
        )) {
            throw new RuntimeException();
        };

        $editCommand = new EditCommand($this->user->id(), $this->request);
        $edit = new Edit($this->userRepository, $this->encryptor);
        $edit($editCommand);
    }

    /**
     * Requestクラスの返り値を設定
     *
     * @param string|null $name
     * @param string|null $email
     * @param string|null $password
     * @param string|null $passwordConfirmation
     * @param string|null $currentPassword
     * @return bool
     */
    private function setRequestValue(
        ?string $name,
        ?string $email,
        ?string $password,
        ?string $passwordConfirmation,
        ?string $currentPassword
    ): bool {
        $this->request = $this->mock(Request::class);
        $this->request->shouldReceive('input')
            ->andReturnUsing(function ($inputName) use ($name, $email, $password, $passwordConfirmation, $currentPassword) {
                switch ($inputName) {
                    case UserConst::INPUT_NEW_NAME:
                        return $name;
                    case UserConst::INPUT_NEW_EMAIL:
                        return $email;
                    case UserConst::INPUT_NEW_PASSWORD:
                        return $password;
                    case UserConst::INPUT_NEW_PASSWORD_CONFIRMATION:
                        return $passwordConfirmation;
                    case UserConst::INPUT_CURRENT_PASSWORD:
                        return $currentPassword;
                    default:
                        throw new InvalidArgumentException($inputName . 'not found.');
                }
            });

        if ($this->request->input(UserConst::INPUT_NEW_NAME) !== $name) {
            return false;
        }
        if ($this->request->input(UserConst::INPUT_NEW_EMAIL) !== $email) {
            return false;
        }
        if ($this->request->input(UserConst::INPUT_NEW_PASSWORD) !== $password) {
            return false;
        }
        if ($this->request->input(UserConst::INPUT_NEW_PASSWORD_CONFIRMATION !== $passwordConfirmation)) {
            return false;
        }
        if ($this->request->input(UserConst::INPUT_CURRENT_PASSWORD !== $currentPassword)) {
            return false;
        }

        return true;
    }
}