<?php
namespace App\UserAccount\UseCase\User\GetList;

use App\UserAccount\Result;

interface GetListInterface
{
    /**
     * ユーザー一覧を取得
     *
     * @param GetListCommandInterface $command
     * @return Result
     */
    public function __invoke(GetListCommandInterface $command): Result;
}
