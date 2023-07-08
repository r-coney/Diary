<?php
namespace App\UserAccount\Infrastructure\Services;

use App\Models\AccessToken;
use Illuminate\Support\Carbon;
use Domain\UserAccount\Models\User\User;
use App\UserAccount\Infrastructure\Test\Repositories\AccessTokenRepository;

class AccessTokenService implements AccessTokenServiceInterface
{
    private AccessTokenRepository $accessTokenRepository;

    public function __construct(AccessTokenRepository $accessTokenRepository)
    {
        $this->accessTokenRepository = $accessTokenRepository;
    }

    public function generate(User $user): AccessToken
    {
        $accessToken = $this->accessTokenRepository->findByUserId($user->id());
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
}
