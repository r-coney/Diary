<?php

namespace Tests\Unit\Domain\UserAccount\Services;

use DateTime;
use Tests\TestCase;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Services\UserService;
use Domain\UserAccount\Models\User\EncryptedPassword;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class UserServiceTest extends TestCase
{
    /**
     * exits()
     * @test
     */
    public function ユーザーが存在する場合はtrueを返すこと()
    {
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime()
        );

        $mockRepository = $this->createMock(UserRepositoryInterface::class);
        $mockRepository
            ->method('findByEmail')
            ->willReturn($user);

        $userService = new UserService($mockRepository);
        $actual = $userService->exists($user);

        $this->assertTrue($actual);
    }

    /**
     * exits()
     * @test
     */
    public function ユーザーが存在しない場合はfalseを返すこと()
    {
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime()
        );

        $mockRepository = $this->createMock(UserRepositoryInterface::class);
        $mockRepository
            ->method('findByEmail')
            ->willReturn(null);

        $userService = new UserService($mockRepository);
        $actual = $userService->exists($user);

        $this->assertFalse($actual);
    }
}
