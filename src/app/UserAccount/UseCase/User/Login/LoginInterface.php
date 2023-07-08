<?php
namespace App\UserAccount\UseCase\User\Login;

use App\Models\AccessToken;

interface LoginInterface
{
    public function __invoke(LoginCommandInterface $command): array;
}
