<?php
namespace App\UserAccount\UseCase\User\VerifyAccessToken;

interface VerifyAccessTokenInterface
{
    /**
     * アクセストークンが有効化か判定
     * @throws AuthenticationException
     * @return bool
     */
    public function __invoke(VerifyTokenCommand $command): bool;
}
