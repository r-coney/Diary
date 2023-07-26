<?php
namespace App\Http\Controllers\UserAccount\User;

use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\Login\LoginCommand;
use App\UserAccount\UseCase\User\Login\LoginInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Login extends Controller
{
    private LoginInterface $login;

    public function __construct(LoginInterface $login)
    {
        $this->login = $login;
    }

    /**
     * ログインし、アクセストークンを発行
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = ($this->login)(new LoginCommand($request));

        if (!$result->hasError()) {
            $loggedInUser = $result->value();
            $response = [
                'status' => 'success',
                'user' => [
                    'id' => $loggedInUser->id,
                    'name' => $loggedInUser->name,
                    'email' => $loggedInUser->email,
                    'registeredDateTime' => $loggedInUser->registeredDateTime,
                    'updatedDateTime' => $loggedInUser->updatedDateTime,
                    'deletedDateTime' => $loggedInUser->deletedDateTime,
                ],
                'accessToken' => $loggedInUser->accessToken,
            ];
            $status = 200;
        } else {
            $response = [
                'status' => 'error',
                'message' => $result->error(),
            ];
            $status = 400;
        }

        return response()->json($response, $status);
    }
}