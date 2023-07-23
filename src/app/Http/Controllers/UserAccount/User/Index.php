<?php

namespace App\Http\Controllers\UserAccount\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\GetList\GetListCommand;
use App\UserAccount\UseCase\User\GetList\GetListInterface;

class Index extends Controller
{
    private GetListInterface $getList;

    public function __construct(GetListInterface $getList)
    {
        $this->getList = $getList;
    }

    public function __invoke(Request $request)
    {
        $userListData = ($this->getList)(new GetListCommand($request));

        return view('user_account.user.index', ['userList' => $userListData->userList()]);
    }
}
