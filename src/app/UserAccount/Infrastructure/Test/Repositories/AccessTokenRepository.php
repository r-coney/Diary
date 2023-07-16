<?php
namespace App\UserAccount\Infrastructure\Test\Repositories;

use App\Models\AccessToken;
use App\UserAccount\Infrastructure\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    private array $store = [];

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

    public function save(AccessToken $accessToken): void
    {
        foreach ($this->store as $index => $token) {
            if ($accessToken->id() === $token->id) {
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