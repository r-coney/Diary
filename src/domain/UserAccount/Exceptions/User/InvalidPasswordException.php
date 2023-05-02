<?php
namespace Domain\UserAccount\Exceptions\User;

use Domain\UserAccount\Exceptions\DomainException;

class InvalidPasswordException extends DomainException
{
    public function render(): void
    {
        
    }
}
