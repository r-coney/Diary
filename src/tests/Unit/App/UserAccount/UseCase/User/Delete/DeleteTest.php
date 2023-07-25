<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\Delete;

use DateTime;
use Tests\TestCase;
use App\UserAccount\UseCase\User\Delete\Delete;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use App\UserAccount\Infrastructure\InMemory\Repositories\UserRepository;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Models\User\InMemoryFactory;
use Domain\UserAccount\Models\User\FactoryInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class DeleteTest extends TestCase
{
    private Encryptor $encryptor;
    private FactoryInterface $userFactory;
    private UserRepositoryInterface $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->encryptor = new BcryptEncryptor();
        $this->userFactory = new InMemoryFactory($this->encryptor);
        $this->userRepository = new UserRepository($this->userFactory);

        $this->registeredUser = $this->userFactory->create(
            new Name('test'),
            new Email('test@example.com'),
            new Password('password1'),
            new DateTime()
        );

        $this->userRepository->save($this->registeredUser);
    }

    /**
     * @test
     */
    public function ユーザーを論理削除できること(): void
    {
        $delete = new Delete($this->userRepository);
        $delete(new Id($this->registeredUser->id()));

        $deletedUser = $this->userRepository->find(new Id($this->registeredUser->id()));
        $deletedDate = new DateTime();
        $this->assertTrue(strpos($deletedUser->deletedDateTime(), $deletedDate->format('Y-m-d H')) !== false);
    }

    /**
     * @test
     */
    public function 削除対象のユーザーが見つからない場合、エラーの結果を返すこと(): void
    {
        $delete = new Delete($this->userRepository);
        $result = $delete(new Id(999));

        $this->assertTrue($result->hasError());
    }
}
