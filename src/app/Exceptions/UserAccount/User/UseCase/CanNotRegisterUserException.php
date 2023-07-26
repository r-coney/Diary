<?php
namespace App\Exceptions\UserAccount\User\UseCase;

use Exception;
use App\Exceptions\ApplicationException;

class CanNotRegisterUserException extends ApplicationException
{
    public function render(): void
    {

    }
}
