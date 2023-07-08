<?php
namespace App\UserAccount\UseCase\User\Login;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use App\UserAccount\Infrastructure\Services\AccessTokenServiceInterface;
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

    public function __invoke(LoginCommandInterface $command): array
    {
        try {
            $user = $this->userRepository->findByEmail(new Email($command->email()));
            if (is_null($user)) {
                throw new InvalidArgumentException('User not Found.');
            }

            if (!$user->verifyPassword($this->encryptor, new Password($command->password()))) {
                throw new InvalidArgumentException('Authentication Failure.');
            }

            $accessToken = DB::transaction(function () use ($user) {
                return $this->accessTokenService->generate($user);
            });

            $response = [
                'status' => 'success',
                'user' => [
                    'id' => $user->id(),
                    'name' => $user->name(),
                    'email' => $user->email(),
                ],
                'token_type' => 'Bearer',
                'access_token' => $accessToken->token
            ];
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'error' => $e->getMessage(),
            ];
        }

        return $response;
    }
}
