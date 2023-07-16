<?php
namespace App\UserAccount\Infrastructure\Services;

use App\Models\AccessToken;
use Domain\UserAccount\Models\User\User;

interface AccessTokenServiceInterface
{
    /**
     * アクセストークンを作成
     *
     * @return AccessToken
     */
    public function generate(User $user): AccessToken;

    /**
     * リクエストされたアクセストークンが有効か判定
     *
     * @param AccessToken $accessToken
     * @param string $requestedToken
     * @return bool
     */
    public function authentication(AccessToken $accessToken, string $requestedToken): bool;
}
