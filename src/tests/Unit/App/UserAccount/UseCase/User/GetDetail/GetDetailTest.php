<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\GetDetail;

use tests\TestCase;
use DateTime;
use App\UserAccount\UseCase\User\GetDetail\GetDetail;
use App\Exceptions\UserAccount\User\UseCase\UserNotFoundException;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\EncryptedPassword;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class GetDetailTest extends TestCase
{
    private UserRepositoryInterface $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function ユーザーの詳細情報を取得できること(): void
    {
        // ユーザーを作成
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime()
        );

        $this->userRepository->method('find')->willReturn($user);

        $getDetail = new GetDetail($this->userRepository);
        $userData = $getDetail(new Id($user->id()));

        $this->assertSame($user->id(), $userData->id);
        $this->assertSame($user->name(), $userData->name);
        $this->assertSame($user->email(), $userData->email);
        $this->assertSame($user->password(), $userData->password);
        $this->assertSame($user->registeredDateTime(), $userData->registeredDateTime);
        $this->assertSame($user->updatedDateTime(), $userData->updatedDateTime);
        $this->assertSame($user->deletedDateTime(), $userData->deletedDateTime);
    }

    /**
     * @test
     */
    public function ユーザーの詳細情報が取得できなかった場合、例外をthrowすること(): void
    {
        $this->expectException(UserNotFoundException::class);

        $this->userRepository->method('find')->willReturn(null);

        $getDetail = new GetDetail($this->userRepository);
        $getDetail(new Id(1));
    }
}
