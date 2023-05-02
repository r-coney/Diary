<?php

namespace App\Http\Controllers\UserAccount\User;

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

    public function __invoke(Request $request)
    {
        $registerCommand = new RegisterCommand(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
            $request->input('passwordConfirmation')
        );

        $response = ($this->register)($registerCommand);

        return redirect()->route('userAccount.user.detail', [
            'id' => $response['user']['id'],
        ]);
    }
}
