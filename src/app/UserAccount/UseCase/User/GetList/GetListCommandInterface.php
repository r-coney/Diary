<?php
namespace App\UserAccount\UseCase\User\GetList;

interface GetListCommandInterface
{
    /**
     * １ページあたりの表示件数を返す
     *
     * @return int
     */
    public function perPage(): int;

    /**
     * ページ番号を返す
     *
     * @return int
     */
    public function page(): int;
}
