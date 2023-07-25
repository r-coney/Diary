<?php
namespace App\UserAccount\UseCase\User\Login;

use App\UserAccount\Result;

interface LoginInterface
{
    /**
     * ログイン処理を行い、アクセストークンを発行
     *
     * @param LoginCommandInterface $command
     * @return Result
     */
    public function __invoke(LoginCommandInterface $command): Result;
}
