<?php
namespace App\UserAccount\UseCase\User\Delete;

use App\UserAccount\Result;
use Domain\UserAccount\Models\User\Id;

interface DeleteInterface
{
    /**
     * ユーザー情報を論理削除
     *
     * @param Id $id
     * @return Result
     */
    public function __invoke(Id $id): Result;
}
