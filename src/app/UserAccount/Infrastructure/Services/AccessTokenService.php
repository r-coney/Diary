<?php
namespace App\UserAccount\Infrastructure\Services;

use DateTime;
use App\Models\AccessToken;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Id as UserId;
use App\UserAccount\Infrastructure\AccessTokenRepositoryInterface;

class AccessTokenService implements AccessTokenServiceInterface
{
    private AccessTokenRepositoryInterface $accessTokenRepository;

    public function __construct(AccessTokenRepositoryInterface $accessTokenRepository)
    {
        $this->accessTokenRepository = $accessTokenRepository;
    }

    public function generate(User $user): AccessToken
    {
        $accessToken = $this->accessTokenRepository->findByUserId(new UserId($user->id()));
        if (is_null($accessToken)) {
            $accessToken = new AccessToken([
                'user_id' => $user->id(),
            ]);
        }

        $accessToken->token = $this->generateToken();
        $accessToken->expires_at = $this->generateExpirationDate();
        $this->accessTokenRepository->save($accessToken);

        return $accessToken;
    }

    /**
     * トークンを作成
     *
     * @return string
     */
    private function generateToken(): string
    {
        return hash('sha256', Str::random(60));
    }

    /**
     * 有効期限日時を作成
     *
     * @return Carbon
     */
    private function generateExpirationDate(): Carbon
    {
        return now()->addHours(24);
    }

    public function authentication(AccessToken $accessToken, string $requestedToken): bool
    {
        if ($accessToken->token !== $requestedToken) {
            return false;
        }

        if (new DateTime($accessToken->expires_at) < new DateTime()) {
            return false;
        }

        return true;
    }
}
