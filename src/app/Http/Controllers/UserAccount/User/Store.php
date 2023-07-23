<?php

namespace App\Http\Controllers\UserAccount\User;

use App\Exceptions\UserAccount\User\UseCase\CanNotRegisterUserException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\Register\RegisterCommand;
use App\UserAccount\UseCase\User\Register\RegisterInterface;

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
     */
    public function __invoke(Request $request)
    {
        try {
            $result = ($this->register)(new RegisterCommand($request));
            if ($result->hasError()) {
                throw new CanNotRegisterUserException($result->error());
            }

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
        } catch (CanNotRegisterUserException $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
            $statusCode = 400;
        }

        return response()->json($response, $statusCode);
    }
}
