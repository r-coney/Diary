<?php

namespace App\Http\Controllers\UserAccount\User;

use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\GetDetail\GetDetailInterface;
use Domain\UserAccount\Models\User\Id;
use Illuminate\Http\JsonResponse;

class Detail extends Controller
{
    private GetDetailInterface $getDetail;

    public function __construct(GetDetailInterface $getDetail)
    {
        $this->getDetail = $getDetail;
    }

    /**
     * ユーザーの詳細情報を取得
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $result = ($this->getDetail)(new Id($id));
        if (!$result->hasError()) {
            $userData = $result->value();
            $response = [
                'status' => 'success',
                'user' => [
                    'name' => $userData->name,
                    'email' => $userData->email,
                    'registeredDateTime' => $userData->registeredDateTime,
                    'updatedDateTime' => $userData->updatedDateTime,
                    'deletedDateTime' => $userData->deletedDateTime,
                ],
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
