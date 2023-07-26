<?php
namespace App\UserAccount\UseCase\User\GetDetail;

use App\UserAccount\Result;
use Domain\UserAccount\Models\User\Id;

interface GetDetailInterface
{
    /**
     * ユーザーの詳細情報を取得
     *
     * @param Id $id
     * @return Result
     */
    public function __invoke(Id $id): Result;
}
