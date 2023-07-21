<?php
namespace App\Exceptions\UserAccount\User\UseCase;

use Exception;
use App\Exceptions\ApplicationException;

class CanNotRegisterUserException extends ApplicationException
{
    public function __construct(Exception $e)
    {
        parent::__construct($e->getMessage());
    }

    public function render(): void
    {

    }
}
