<?php
namespace App\UserAccount\UseCase\User\VerifyAccessToken;

use App\UserAccount\Infrastructure\AccessTokenRepositoryInterface;
use App\UserAccount\Infrastructure\Services\AccessTokenServiceInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;
use Domain\UserAccount\Models\User\Id as UserId;
use Illuminate\Auth\AuthenticationException;

class VerifyAccessToken implements VerifyAccessTokenInterface
{
    private UserRepositoryInterface $userRepository;
    private AccessTokenRepositoryInterface $accessTokenRepository;
    private AccessTokenServiceInterface $accessToeknService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AccessTokenRepositoryInterface $accessTokenRepository,
        AccessTokenServiceInterface $accessToeknService
    ) {
        $this->userRepository = $userRepository;
        $this->accessTokenRepository = $accessTokenRepository;
        $this->accessToeknService = $accessToeknService;
    }

    public function __invoke(VerifyTokenCommand $command): bool
    {
        $user = $this->userRepository->find(id: new UserId($command->userId()));
        if (is_null($user)) {
            throw new AuthenticationException('User not found.');
        }

        $accessToken = $this->accessTokenRepository->findByUserId(new UserId($user->id()));
        if (is_null($accessToken)) {
            throw new AuthenticationException('AccessToken not found.');
        }

        if (!$accessToken->verify(accessTokenService: $this->accessToeknService, requestedToken: $command->accessToken())) {
            throw new AuthenticationException('Invalid access token.');
        }

        return true;
    }
}