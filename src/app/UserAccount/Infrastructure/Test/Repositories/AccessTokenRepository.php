<?php
namespace App\UserAccount\Infrastructure\Test\Repositories;

use App\Models\AccessToken;
use App\UserAccount\Infrastructure\AccessTokenRepositoryInterface;
use Domain\UserAccount\Models\User\Id as UserId;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    private array $store = [];
    private int $currentId;

    public function __construct()
    {
        $this->currentId = 0;
    }

    public function store(): array
    {
        return $this->store;
    }

    public function find(int $id): AccessToken
    {
        foreach ($this->store() as $index => $token) {
            if ($id === $token->id) {
                return new AccessToken(
                    [
                        'id' => $token->id,
                        'user_id' => $token->user_id,
                        'token' => $token->token,
                        'expires_at' => $token->expires_at,
                        'created_at' => $token->created_at,
                        'updated_at' => $token->updated_at,
                    ]
                );
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

    public function save(AccessToken $accessToken): void
    {
        if (is_null($accessToken->id)) {
            $this->currentId++;
            $accessToken->id = $this->currentId;
        }

        foreach ($this->store as $index => $token) {
            if ($accessToken->id === $token->id) {
                unset($this->store[$index]);
            }
        }

        $this->store[] = (object) [
            'id' => $accessToken->id,
            'user_id' => $accessToken->user_id,
            'token' => $accessToken->token,
            'expires_at' => $accessToken->expires_at,
            'created_at' => $accessToken->created_at,
            'updated_at' => $accessToken->updated_at,
        ];
    }
}