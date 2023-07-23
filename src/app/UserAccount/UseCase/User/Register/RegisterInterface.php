<?php
namespace App\UserAccount\UseCase\User\Register;

use App\UserAccount\Result;

interface RegisterInterface
{
    /**
     * ユーザーアカウントを新規登録
     *
     * @param RegisterCommandInterface $registerCommand
     * @return Result
     */
    public function __invoke(RegisterCommandInterface $registerCommand): Result;
}
