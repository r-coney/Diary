<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\GetList;

use Tests\TestCase;
use App\UserAccount\UseCase\User\GetList\UserListQueryData;

class UserListQueryDataTest extends TestCase
{
    private array $userList;

    public function setUp(): void
    {
        parent::setUp();
        $this->userList = [
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane'],
            ['id' => 3, 'name' => 'Mike'],
        ];
    }
    /**
     * @test
     */
    public function ユーザー一覧を取得できること(): void
    {
        $currentPage = 1;
        $totalPages = 2;
        $queryData = new UserListQueryData($this->userList, $currentPage, $totalPages);

        $this->assertEquals($this->userList, $queryData->userList());
    }

    /**
     * @test
     */
    public function 取得対象ページを取得できること(): void
    {
        $currentPage = 1;
        $totalPages = 2;
        $queryData = new UserListQueryData($this->userList, $currentPage, $totalPages);

        $this->assertEquals($this->userList, $queryData->userList());
    }


    /**
     * @test
     */
    public function トータルページ数を取得できること(): void
    {
        $currentPage = 1;
        $totalPages = 2;
        $queryData = new UserListQueryData($this->userList, $currentPage, $totalPages);

        $this->assertEquals($totalPages, $queryData->totalPages());
    }
}
