<?php
namespace App\UserAccount\UseCase\User\Logout;

use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\UserAccount\User\UseCase\UserNotFoundException;
use App\UserAccount\UseCase\User\Logout\LogoutInterface;
use App\UserAccount\Infrastructure\AccessTokenRepositoryInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;
use Domain\UserAccount\Models\User\Id as UserId;

class Logout implements LogoutInterface
{
    private UserRepositoryInterface $userRepository;
    private AccessTokenRepositoryInterface $accessTokenRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AccessTokenRepositoryInterface $accessTokenRepository
    ) {
        $this->userRepository = $userRepository;
        $this->accessTokenRepository = $accessTokenRepository;
    }

    public function __invoke(LogoutCommand $logoutCommand): bool
    {
        if (!$logoutCommand->hasUserId()) {
            throw new NotFoundHttpException('User ID not found.');
        }

        $user = $this->userRepository->find(new UserId($logoutCommand->userId()));
        if (is_null($user)) {
            throw new UserNotFoundException('User not found.');
        }

        $accessToken = $this->accessTokenRepository->findByUserId(new UserId($user->id()));
        if (is_null($accessToken)) {
            return true;
        }

        $is_deleted = DB::transaction(function () use ($accessToken) {
            return $this->accessTokenRepository->delete($accessToken);
        });

        if (!$is_deleted) {
            throw new RuntimeException('Failed to delete access token');
        }

        return true;
    }
}
