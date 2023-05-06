<?php
namespace App\Exceptions\UserAccount\User\UseCase;

use App\Exceptions\ApplicationException;

class CanNotEditUserException extends ApplicationException
{
    public function render(): void
    {

    }
}
