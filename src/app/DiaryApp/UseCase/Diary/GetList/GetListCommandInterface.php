<?php
namespace App\DiaryApp\UseCase\Diary\GetList;

interface GetListCommandInterface
{
    /**
     * User ID を取得
     *
     * @return int
     */
    public function userId(): int;

    /**
     * 1ページあたりの表示件数を取得
     *
     * @return int
     */
    public function perPage(): int;

    /**
     * ページ番号を取得
     *
     * @return int
     */
    public function page(): int;
}
