<?php
namespace App\UserAccount\Infrastructure;

use App\Models\AccessToken;
use Domain\UserAccount\Models\User\Id as UserId;

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
     * 指定のユーザーのアクセストークンを取得
     *
     * @param UserId $userId
     * @return AccessToken|null
     */
    public function findByUserId(UserId $userId): ?AccessToken;

    /**
     * アクセストークンを保存
     *
     * @param AccessToken $accessToken
     * @return void
     */
    public function save(AccessToken $accessToken): void;
}