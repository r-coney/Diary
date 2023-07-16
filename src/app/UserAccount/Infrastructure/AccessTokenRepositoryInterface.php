<?php
namespace App\UserAccount\Infrastructure;

use App\Models\AccessToken;

interface AccessTokenRepositoryInterface
{
    /**
     * idに紐づくアクセストークンを取得
     *
     * @param int $id
     * @return AccessToken|null
     */
    public function find(int $id): ?AccessToken;

    /**
     * アクセストークンを保存
     *
     * @param AccessToken $accessToken
     * @return void
     */
    public function save(AccessToken $accessToken): void;
}
