<?php
namespace App\UserAccount\UseCase\User\Logout;

use Illuminate\Http\Request;

class LogoutCommand
{
    private ?int $userId;

    public function __construct(Request $request)
    {
        $this->userId = $request->input('user_id');
    }

    /**
     * ユーザーIDを取得
     *
     * @return int|null
     */
    public function userId(): ?int
    {
        return $this->userId;
    }

    /**
     * ユーザーIDが存在するか判定
     *
     * @return boolean
     */
    public function hasUserId(): bool
    {
        return $this->userId !== null;
    }
}
