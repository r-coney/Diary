<?php
namespace App\UserAccount\UseCase\User;

use App\UserAccount\UseCase\User\GetList\UserListQueryData;
use App\UserAccount\UseCase\User\GetList\GetListCommandInterface;

interface QueryServiceInterface
{
    /**
     * ユーザー一覧を取得
     *
     * @param GetListCommandInterface $command
     * @return UserListQueryData
     */
    public function getAll(GetListCommandInterface $command): UserListQueryData;
}
