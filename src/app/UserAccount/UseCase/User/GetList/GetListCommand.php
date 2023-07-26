<?php
namespace App\UserAccount\UseCase\User\GetList;

use App\UserAccount\Consts\UserConst;
use Illuminate\Http\Request;

class GetListCommand implements GetListCommandInterface
{
    private int $page;
    private int $perPage;

    const FIRST_PAGE = 1;
    const DEFAULT_PER_PAGE = 10;

    public function __construct(Request $request)
    {
        $this->page = $request->query(UserConst::QUERY_NAME_PAGE) ?: self::FIRST_PAGE;
        $this->perPage = $request->query(UserConst::QUERY_NAME_PER_PAGE) ?: self::DEFAULT_PER_PAGE;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }
}
