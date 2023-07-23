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
use RuntimeException;

class GetListTest extends TestCase
{
    private UserFActoryInterface $userFactory;
    private UserRepositoryInterface $userRepository;
    private UserQueryServiceInterface $userQueryService;
    private GetListCommand $getListCommand;
    const PER_PAGE = 3;

    public function setUp(): void
    {
        parent::setUp();

        $encryptor = new BcryptEncryptor();
        $this->userFactory = new UserFactory($encryptor);
        $this->userRepository = new UserRepository($this->userFactory);
        $this->userQueryService = new UserQueryService($this->userRepository);
        $this->getListCommand = $this->mock(GetListCommand::class);

        $users = [
            $this->userFactory->create(
                name: new Name('John'),
                email: new Email('test@example.com'),
                password: new Password('password1'),
                registeredDateTime: new DateTime()
            ),
            $this->userFactory->create(
                name: new Name('sarah'),
                email: new Email('test2@example.com'),
                password: new Password('password1'),
                registeredDateTime: new DateTime()
            ),
            $this->userFactory->create(
                name: new Name('kate'),
                email: new Email('test3@example.com'),
                password: new Password('password1'),
                registeredDateTime: new DateTime()
            ),
            $this->userFactory->create(
                name: new Name('mike'),
                email: new Email('test4@example.com'),
                password: new Password('password1'),
                registeredDateTime: new DateTime()
            ),
        ];

        foreach ($users as $user) {
            $this->userRepository->save($user);
        }
    }

    /**
     * @test
     */
    public function ユーザー一覧を取得できること(): void
    {
        $this->setCommandReturnValue(page: 1, perPage: self::PER_PAGE);
        $getList = new GetList($this->userQueryService);

        $result = $getList($this->getListCommand);
        if ($result->hasError()) {
            throw new RuntimeException($result->error());
        }

        $userListData = $result->value();

        $this->assertInstanceOf(UserListQueryData::class, $userListData);
        $this->assertSame(self::PER_PAGE, count($userListData->userList()));
    }

    /**
     * コマンドの返り値を設定
     *
     * @param int|null $page
     * @param int|null $perPage
     * @return bool
     */
    public function setCommandReturnValue(?int $page, ?int $perPage): bool
    {
        $this->getListCommand->shouldReceive('page')
            ->andReturn($page);

        $this->getListCommand->shouldReceive('perPage')
            ->andReturn($perPage);

        if ($this->getListCommand->page() !== $page) {
            return false;
        }

        if ($this->getListCommand->perPage() !== $perPage) {
            return false;
        }

        return true;
    }
}
