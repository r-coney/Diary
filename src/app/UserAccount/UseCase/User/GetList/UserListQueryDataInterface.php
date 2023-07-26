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
     * 取得したページを返す
     *
     * @return int
     */
    public function currentPage(): int;

    /**
     * ページ数を返す
     *
     * @return int
     */
    public function totalPages(): int;
}
