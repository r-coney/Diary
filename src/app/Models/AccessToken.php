<?php

namespace App\Models;

use App\UserAccount\Infrastructure\Services\AccessTokenServiceInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'token',
        'expires_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function verify(AccessTokenServiceInterface $accessTokenService, string $requestedToken): bool
    {
        return $accessTokenService->authentication(accessToken: $this, requestedToken: $requestedToken);
    }
}
