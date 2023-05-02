<?php
namespace App\Exceptions\UserAccount\User\UseCase;

use App\Exceptions\ApplicationException;

class UserNotFoundException extends ApplicationException
{
    public function render(): void
    {

    }
}