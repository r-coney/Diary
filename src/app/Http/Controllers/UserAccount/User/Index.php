<?php

namespace App\Http\Controllers\UserAccount\User;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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

    /**
     * ユーザー一覧を取得
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = ($this->getList)(new GetListCommand($request));
        if (!$result->hasError()) {
            $userListData = $result->value();
            $response = [
                'status' => 'success',
                'users' => $userListData->userList(),
                'currentPage' => $userListData->currentPage(),
                'totalPages' => $userListData->totalPages(),
            ];
            $statusCode = 200;
        } else {
            $response = [
                'status' => 'error',
                'message' => $result->error(),
            ];
            $statusCode = 400;
        }

        return response()->json($response, $statusCode);
    }
}
