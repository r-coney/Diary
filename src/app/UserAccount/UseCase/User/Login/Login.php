<?php
namespace App\UserAccount\UseCase\User\Login;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use App\UserAccount\Infrastructure\Services\AccessTokenServiceInterface;
use App\UserAccount\Result;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class Login implements LoginInterface
{
    private UserRepositoryInterface $userRepository;
    private Encryptor $encryptor;
    private AccessTokenServiceInterface $accessTokenService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        Encryptor $encryptor,
        AccessTokenServiceInterface $accessTokenService
    ) {
        $this->userRepository = $userRepository;
        $this->encryptor = $encryptor;
        $this->accessTokenService = $accessTokenService;
    }

    public function __invoke(LoginCommandInterface $command): Result
    {
        try {
            $user = $this->userRepository->findByEmail(new Email($command->email()));
            if (is_null($user)) {
                throw new InvalidArgumentException('User not Found.');
            }

            if (!$user->verifyPassword(encryptor: $this->encryptor, password: new Password($command->password()))) {
                throw new InvalidArgumentException('Authentication Failure.');
            }

            $accessToken = DB::transaction(function () use ($user) {
                return $this->accessTokenService->generate($user);
            });

            $result = Result::ofValue(new LoggedInUserData(user: $user, accessToken: $accessToken));
        } catch (Exception $e) {
            $result = Result::ofError($e->getMessage());
        }

        return $result;
    }
}
