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
        $response = ($this->register)(new RegisterCommand($request));

        return redirect()->route('userAccount.user.detail', [
            'id' => $response['user']['id'],
        ]);
    }
}
