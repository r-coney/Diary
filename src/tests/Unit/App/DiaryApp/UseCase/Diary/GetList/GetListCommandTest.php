<?php

namespace Tests\Unit\App\DiaryApp\UseCase\Diary\GetList;

use Tests\TestCase;
use App\DiaryApp\UseCase\Diary\GetList\GetListCommand;

class GetListCommandTest extends TestCase
{
    /**
     * @test
     */
    public function ユーザーIDを取得できること()
    {
        $userId = 1;
        $perPage = 10;
        $page = 1;

        $getListCommand = new GetListCommand($userId, $perPage, $page);

        $this->assertEquals($userId, $getListCommand->userId());
    }

    /**
     * @test
     */
    public function ページあたりの件数を取得できること()
    {
        $userId = 1;
        $perPage = 10;
        $page = 1;

        $getListCommand = new GetListCommand($userId, $perPage, $page);

        $this->assertEquals($perPage, $getListCommand->perPage());
    }

    /**
     * @test
     */
    public function 現在のページ数を取得できること()
    {
        $userId = 1;
        $perPage = 10;
        $page = 1;

        $getListCommand = new GetListCommand($userId, $perPage, $page);

        $this->assertEquals($page, $getListCommand->page());
    }
}
