<?php

namespace App\Http\Controllers\UserAccount\User;

use App\Http\Controllers\Controller;

class Register extends Controller
{
    public function __invoke()
    {
        return view('user_account.user.register');
    }
}
