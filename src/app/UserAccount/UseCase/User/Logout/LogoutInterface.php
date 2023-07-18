<?php
namespace App\UserAccount\UseCase\User\Logout;

interface LogoutInterface
{
    public function __invoke(LogoutCommand $logoutCommand): bool;
}
