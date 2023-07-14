<?php

namespace App\Http\Controllers\UserAccount\User;

use App\Http\Controllers\Controller;
use App\UserAccount\UseCase\User\Login\LoginCommand;
use App\UserAccount\UseCase\User\Login\LoginInterface;
use Illuminate\Http\Request;

class Login extends Controller
{
    private LoginInterface $login;

    private function __construct(LoginInterface $login)
    {
        $this->login = $login;
    }

    public function __invoke(Request $request)
    {
        $response = ($this->login)(new LoginCommand(
            $request->input('email'),
            $request->input('password'))
        );

        if ($response['status'] = 'success') {
            $status = 200;
        } else {
            $status = 400;
        }

        return response()->json($response, $status);
    }
}