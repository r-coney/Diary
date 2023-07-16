<?php
namespace App\UserAccount\UseCase\User\VerifyAccessToken;

use Illuminate\Http\Request;

class VerifyTokenCommand
{
    private ?int $userId;
    private ?string $accessToken;

    public function __construct(Request $request)
    {
        $this->userId = $request->input('user_id');
        $this->accessToken = $request->input('access_token');
    }

    public function userId(): ?int
    {
        return $this->userId;
    }

    public function accessToken(): ?string
    {
        return $this->accessToken;
    }
}
