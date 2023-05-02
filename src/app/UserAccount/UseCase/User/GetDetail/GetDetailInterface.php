<?php
namespace App\UserAccount\UseCase\User\GetDetail;

use Domain\UserAccount\Models\User\Id;
use App\UserAccount\UseCase\User\GetDetail\UserData;

interface GetDetailInterface
{
    /**
     * ユーザーの詳細情報を取得
     *
     * @param Id $id
     * @return UserData
     */
    public function __invoke(Id $id): UserData;
}
