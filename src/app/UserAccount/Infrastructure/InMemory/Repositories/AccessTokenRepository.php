<?php
namespace App\UserAccount\Infrastructure\InMemory\Repositories;

use App\Models\AccessToken;
use Illuminate\Support\Facades\Cache;
use Domain\UserAccount\Models\User\Id as UserId;
use App\UserAccount\Infrastructure\AccessTokenRepositoryInterface;

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

    public function save(AccessToken $accessToken): ?AccessToken
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

        return $accessToken;
    }

    public function find(int $id): ?AccessToken
    {
        foreach ($this->store() as $entity) {
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
        foreach ($this->store() as $entity) {
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

    public function delete(AccessToken $accessToken): bool
    {
        $isDeleted = false;
        foreach ($this->store() as $index => $entity) {
            if ($accessToken->id === $entity->id) {
                unset($this->store[$index]);
                $isDeleted = true;
            }
        }

        Cache::put('accessTokens', $this->store);

        if (!$isDeleted) {
            return false;
        }

        return true;
    }
}