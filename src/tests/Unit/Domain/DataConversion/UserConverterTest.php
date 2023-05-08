<?php

namespace Tests\Unit\Domain\DataConversion;

use DateTime;
use PHPUnit\Framework\TestCase;
use Domain\UserAccount\Models\User\Id;
use Domain\DataConversion\UserConverter;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\EncryptedPassword;
use Domain\DiaryApp\Models\User\User as DiaryAppUser;

class UserConverterTest extends TestCase
{
    private UserConverter $userConverter;

    public function setUp(): void
    {
        $this->userConverter = new UserConverter();
    }

    /**
     * toDiaryApp()
     * @test
     */
    public function UserAccountコンテキストのUserをDiaryAppコンテキストのUserに変換できること(): void
    {
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password1'),
            new DateTime()
        );

        $diaryAppUser = $this->userConverter->toDiaryApp($user);

        $this->assertInstanceOf(DiaryAppUser::class, $diaryAppUser);
        $this->assertSame($user->id(), $diaryAppUser->id());
    }
}
