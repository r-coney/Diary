<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\GetList;

use PHPUnit\Framework\TestCase;
use App\UserAccount\UseCase\User\GetList\UserListQueryData;

class UserListQueryDataTest extends TestCase
{
    /**
     * @test
     */
    public function ユーザー一覧を取得できること(): void
    {
        $userList = [
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane'],
            ['id' => 3, 'name' => 'Mike']
        ];
        $totalPages = 2;

        $queryData = new UserListQueryData($userList, $totalPages);

        $this->assertEquals($userList, $queryData->userList());
    }

    /**
     * @test
     */
    public function トータルページ数を取得できること(): void
    {
        $userList = [
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane'],
            ['id' => 3, 'name' => 'Mike']
        ];
        $totalPages = 2;

        $queryData = new UserListQueryData($userList, $totalPages);

        $this->assertEquals($totalPages, $queryData->totalPages());
    }
}
