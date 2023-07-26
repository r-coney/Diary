<?php
namespace App\UserAccount\UseCase\User\VerifyAccessToken;

use Exception;
use Illuminate\Auth\AuthenticationException;
use App\UserAccount\Infrastructure\AccessTokenRepositoryInterface;
use App\UserAccount\Infrastructure\Services\AccessTokenServiceInterface;
use App\UserAccount\Result;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;
use Domain\UserAccount\Models\User\Id as UserId;

class VerifyAccessToken implements VerifyAccessTokenInterface
{
    private UserRepositoryInterface $userRepository;
    private AccessTokenRepositoryInterface $accessTokenRepository;
    private AccessTokenServiceInterface $accessTokenService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AccessTokenRepositoryInterface $accessTokenRepository,
        AccessTokenServiceInterface $accessTokenService
    ) {
        $this->userRepository = $userRepository;
        $this->accessTokenRepository = $accessTokenRepository;
        $this->accessTokenService = $accessTokenService;
    }

    public function __invoke(VerifyTokenCommand $command): Result
    {
        try {
            $user = $this->userRepository->find(id: new UserId($command->userId()));
            if (is_null($user)) {
                throw new AuthenticationException('User not found.');
            }

            $accessToken = $this->accessTokenRepository->findByUserId(new UserId($user->id()));
            if (is_null($accessToken)) {
                throw new AuthenticationException('AccessToken not found.');
            }

            if (!$accessToken->verify(accessTokenService: $this->accessTokenService, requestedToken: $command->accessToken())) {
                throw new AuthenticationException('Invalid access token.');
            }

            $result = Result::ofValue(true);
        } catch (Exception $e) {
            $result = Result::ofError($e->getMessage());
        }

        return $result;
    }
}
