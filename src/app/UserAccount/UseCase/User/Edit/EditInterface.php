<?php
namespace App\UserAccount\UseCase\User\Edit;

use App\UserAccount\Result;
use App\UserAccount\UseCase\User\Edit\EditCommandInterface;

interface  EditInterface
{
    /**
     * ユーザー情報を編集
     *
     * @param EditCommandInterface $command
     * @return Result
     */
    public function __invoke(EditCommandInterface $command): Result;
}
