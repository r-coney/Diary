<?php

namespace App\Http\Controllers\UserAccount\User;

use App\Exceptions\UserAccount\User\UseCase\CanNotRegisterUserException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\Register\RegisterCommand;
use App\UserAccount\UseCase\User\Register\RegisterInterface;
use Illuminate\Http\JsonResponse;

class Store extends Controller
{
    private $register;

    public function __construct(
        RegisterInterface $register
    ) {
        $this->register = $register;
    }

    /**
     * ユーザーアカウントを新規登録
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = ($this->register)(new RegisterCommand($request));
        if (!$result->hasError()) {
            $registeredUser = $result->value();
            $response = [
                'status' => 'success',
                'user' => [
                    'id' => $registeredUser->id(),
                    'name' => $registeredUser->name(),
                    'email' => $registeredUser->email(),
                    'registered_datetime' => $registeredUser->registeredDatetime(),
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
