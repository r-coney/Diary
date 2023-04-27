<?php
namespace App\UserAccount\UseCase\User\Register;

use App\UserAccount\UseCase\User\Register\RegisterCommandInterface;

class RegisterCommand implements RegisterCommandInterface
{
    private string $name;
    private string $email;
    private string $password;
    private string $passwordConfirmation;

    public function __construct(
        string $name,
        string $email,
        string $password,
        string $passwordConfirmation
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
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
