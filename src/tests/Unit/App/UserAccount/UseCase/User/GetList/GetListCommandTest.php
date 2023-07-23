<?php

namespace Tests\Unit\App\UserAccount\UseCase\User\GetList;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\UserAccount\Consts\UserConst;
use App\UserAccount\UseCase\User\GetList\GetListCommand;
use InvalidArgumentException;

class GetListCommandTest extends TestCase
{
    private Request $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = $this->mock(Request::class);
    }

    /**
     * @test
     */
    public function コマンドの値を取得できること(): void
    {
        $page = 2;
        $perPage = 10;
        $this->setRequestReturnValue(page: $page, perPage: $perPage);

        $command = new GetListCommand($this->request);

        $this->assertSame($page, $command->page());
        $this->assertSame($perPage, $command->perPage());
    }

    /**
     * @test
     */
    public function クエリパラメータが存在しない場合、デフォルト値を取得できること(): void
    {
        $this->setRequestReturnValue(page: null, perPage: null);

        $command = new GetListCommand($this->request);

        $this->assertSame(GetListCommand::FIRST_PAGE, $command->page());
        $this->assertSame(GetListCommand::DEFAULT_PER_PAGE, $command->perPage());
    }

    /**
     * Requestの返す値を設定
     *
     * @param int|null $page
     * @param int|null $perPage
     * @return bool
     */
    private function setRequestReturnValue(?int $page, ?int $perPage): bool
    {
        $this->request->shouldReceive('query')
            ->andReturnUsing(function ($queryName) use ($page, $perPage) {
                switch ($queryName) {
                    case UserConst::QUERY_NAME_PAGE:
                        return $page;
                    case UserConst::QUERY_NAME_PER_PAGE:
                        return $perPage;
                    default:
                        throw new InvalidArgumentException('');
                }
            });

        if ($this->request->query(UserConst::QUERY_NAME_PAGE) !== $page) {
            return false;
        }

        if ($this->request->query(UserConst::QUERY_NAME_PER_PAGE) !== $perPage) {
            return false;
        }

        return true;
    }
}
