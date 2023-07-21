<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\GetList;

use DateTime;
use Tests\TestCase;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use App\UserAccount\Infrastructure\InMemory\Queries\UserQueryService;
use App\UserAccount\UseCase\User\QueryServiceInterface as UserQueryServiceInterface;
use App\UserAccount\Infrastructure\InMemory\Repositories\UserRepository;
use App\UserAccount\UseCase\User\GetList\GetList;
use App\UserAccount\UseCase\User\GetList\GetListCommand;
use App\UserAccount\UseCase\User\GetList\UserListQueryData;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\InMemoryFactory as UserFactory;
use Domain\UserAccount\Models\User\FactoryInterface as UserFActoryInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class GetListTest extends TestCase
{
    private UserFActoryInterface $userFactory;
    private UserRepositoryInterface $userRepository;
    private UserQueryServiceInterface $userQueryService;
    const PER_PAGE = 3;

    public function setUp(): void
    {
        parent::setUp();

        $encryptor = new BcryptEncryptor();
        $this->userFactory = new UserFactory($encryptor);
        $this->userRepository = new UserRepository($this->userFactory);
        $this->userQueryService = new UserQueryService($this->userRepository);
    }

    /**
     * @test
     */
    public function ユーザー一覧を取得できること(): void
    {
        $users = [
            $this->userFactory->create(
                new Name('John'),
                new Email('test@example.com'),
                new Password('password1'),
                new DateTime()
            ),
            $this->userFactory->create(
                new Name('sarah'),
                new Email('test2@example.com'),
                new Password('password1'),
                new DateTime()
            ),
            $this->userFactory->create(
                new Name('kate'),
                new Email('test3@example.com'),
                new Password('password1'),
                new DateTime()
            ),
            $this->userFactory->create(
                new Name('mike'),
                new Email('test4@example.com'),
                new Password('password1'),
                new DateTime()
            ),
        ];

        foreach ($users as $user) {
            $this->userRepository->save($user);
        }

        $page = 1;
        $getListCommand = new GetListCommand($page, self::PER_PAGE);
        $getList = new GetList($this->userQueryService);

        $userListData = $getList($getListCommand);

        $this->assertInstanceOf(UserListQueryData::class, $userListData);
        $this->assertSame(self::PER_PAGE, count($userListData->userList()));
    }
}
