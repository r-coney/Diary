<?php
namespace App\UserAccount\UseCase\User\Register;

use App\UserAccount\Consts\UserConst;
use App\UserAccount\UseCase\User\Register\RegisterCommandInterface;
use Illuminate\Http\Request;

class RegisterCommand implements RegisterCommandInterface
{
    private string $name;
    private string $email;
    private string $password;
    private string $passwordConfirmation;

    public function __construct(
        Request $request
    ) {
        $this->name = $request->input(UserConst::INPUT_NAME);
        $this->email = $request->input(UserConst::INPUT_EMAIL);
        $this->password = $request->input(UserConst::INPUT_PASSWORD);
        $this->passwordConfirmation = $request->input(UserConst::INPUT_PASSWORD_CONFIRMATION);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function passwordConfirmation(): string
    {
        return $this->passwordConfirmation;
    }
}
