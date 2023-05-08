<?php
namespace App\UserAccount\UseCase\User\GetList;

interface GetListInterface
{
    /**
     * ユーザー一覧を取得
     */
    public function __invoke(GetListCommandInterface $command): UserListQueryData;
}
