<?php
namespace App\UserAccount\Infrastructure\InMemory\Repositories;

use App\Models\AccessToken;
use App\UserAccount\Infrastructure\AccessTokenRepositoryInterface;
use Domain\UserAccount\Models\User\Id as UserId;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    public function __construct()
    {
        $this->store = Cache::get('accessTokens', []);
    }

    public function store(): array
    {
        $this->store = Cache::get('accessTokens', []);
        return $this->store;
    }

    public function save(AccessToken $accessToken): void
    {
        $store = $this->store();
        foreach ($store as $index => $entity) {
            if ($accessToken->id === $entity->id) {
                unset($store[$index]);
            }
        }

        $store[] = (object) [
            'id' => $accessToken->id,
            'user_id' => $accessToken->user_id,
            'token' => $accessToken->token,
            'expires_at' => $accessToken->expires_at,
        ];

        Cache::put('accessTokens', $store);
    }

    public function find(int $id): ?AccessToken
    {
        foreach ($this->store as $entity) {
            if ($id === $entity->id) {
                return new AccessToken([
                    'id' => $entity->id,
                    'user_id' => $entity->user_id,
                    'token' => $entity->token,
                    'expires_at' => $entity->expires_at,
                ]);
            }
        }

        return null;
    }

    public function findByUserId(UserId $userId): ?AccessToken
    {
        foreach ($this->store as $entity) {
            if ($userId->value() === $entity->user_id) {
                return new AccessToken([
                    'id' => $entity->id,
                    'user_id' => $entity->user_id,
                    'token' => $entity->token,
                    'expires_at' => $entity->expires_at,
                ]);
            }
        }

        return null;
    }
}