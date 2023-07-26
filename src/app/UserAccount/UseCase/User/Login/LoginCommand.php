<?php
namespace App\UserAccount\UseCase\User\Login;

use App\UserAccount\Consts\UserConst;
use Illuminate\Http\Request;

class LoginCommand implements LoginCommandInterface
{
    private string $email;
    private string $password;

    public function __construct(Request $request)
    {
        $this->email = $request->input(UserConst::INPUT_EMAIL);
        $this->password = $request->input(UserConst::INPUT_PASSWORD);
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
