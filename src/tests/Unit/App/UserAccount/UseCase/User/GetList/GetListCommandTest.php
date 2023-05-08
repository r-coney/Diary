<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\GetList;

use PHPUnit\Framework\TestCase;
use App\UserAccount\UseCase\User\GetList\GetListCommand;

class GetListCommandTest extends TestCase
{
    /**
     * @test
     */
    public function コマンドの値を取得できること(): void
    {
        $page = 2;
        $perPage = 10;

        $command = new GetListCommand($page, $perPage);

        $this->assertSame($page, $command->page());
        $this->assertSame($perPage, $command->perPage());
    }
}
