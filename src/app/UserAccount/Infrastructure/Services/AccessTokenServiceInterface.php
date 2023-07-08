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
}
