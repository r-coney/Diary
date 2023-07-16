<?php
namespace App\UserAccount\UseCase\User\VerifyAccessToken;

interface VerifyAccessTokenInterface
{
    /**
     * アクセストークンが有効化か判定
     * @return bool
     */
    public function __invoke(VerifyTokenCommand $command): bool;
}
