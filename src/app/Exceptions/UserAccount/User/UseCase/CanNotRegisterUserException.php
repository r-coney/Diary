<?php
namespace App\Exceptions\UserAccount\User\UseCase;

use App\Exceptions\ApplicationException;

class CanNotRegisterUserException extends ApplicationException
{
    public function render(): void
    {

    }
}
