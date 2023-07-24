<?php

namespace App\Http\Controllers\UserAccount\User;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\Edit\EditCommand;
use App\UserAccount\UseCase\User\Edit\EditInterface;

class Update extends Controller
{
    private EditInterface $edit;

    public function __construct(EditInterface $edit)
    {
        $this->edit = $edit;
    }

    /**
     * ユーザー情報を編集
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(Request $request, int $id): JsonResponse
    {
        $result = ($this->edit)(new EditCommand($id, $request));
        if (!$result->hasError()) {
            $editedUser = $result->value();
            $response = [
                'status' => 'success',
                'user' => [
                    'id' => $editedUser->id(),
                    'name' => $editedUser->name(),
                    'email' => $editedUser->email(),
                    'registeredDateTime' => $editedUser->registeredDateTime(),
                    'updatedDateTime' => $editedUser->updatedDateTime(),
                    'deletedDateTime' => $editedUser->deletedDateTime(),
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
