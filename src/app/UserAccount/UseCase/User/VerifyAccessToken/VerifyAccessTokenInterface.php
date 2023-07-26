<?php
namespace App\UserAccount\UseCase\User\VerifyAccessToken;

use App\UserAccount\Result;

interface VerifyAccessTokenInterface
{
    /**
     * アクセストークンが有効化か判定
     *
     * @return Result
     */
    public function __invoke(VerifyTokenCommand $command): Result;
}
