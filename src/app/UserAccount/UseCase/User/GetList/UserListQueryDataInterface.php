<?php
namespace App\UserAccount\UseCase\User\GetList;

interface UserListQueryDataInterface
{
    /**
     * ユーザー一覧を返す
     *
     * @return array
     */
    public function userList(): array;

    /**
     * ページ数を返す
     *
     * @return int
     */
    public function totalPages(): int;
}
