<?php
namespace App\UserAccount\UseCase\User\Register;

use DateTime;
use Illuminate\Support\Facades\DB;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Services\UserService;
use Domain\UserAccount\Models\User\FactoryInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;
use App\Exceptions\UserAccount\User\UseCase\CanNotRegisterUserException;

class Register implements RegisterInterface
{
    private FactoryInterface $userFactory;
    private UserService $UserService;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        FactoryInterface $userFactory,
        UserService $userService,
        UserRepositoryInterface $userRepository
    ) {
        $this->userFactory = $userFactory;
        $this->UserService = $userService;
        $this->userRepository = $userRepository;
    }

    public function __invoke(RegisterCommandInterface $registerCommand): array
    {
        try {
            if ($registerCommand->password() !== $registerCommand->passwordConfirmation()) {
                throw new CanNotRegisterUserException('パスワードが一致しません');
            }

            $user = DB::transaction(function () use ($registerCommand) {
                $user = $this->userFactory->create(
                    new Name($registerCommand->name()),
                    new Email($registerCommand->email()),
                    new Password($registerCommand->password()),
                    new DateTime(),
                );

                if ($this->UserService->exists($user)) {
                    throw new CanNotRegisterUserException('ユーザーは既に存在しています');
                }

                $this->userRepository->save($user);

                return $user;
            });

            $response = [
                'status' => 'success',
                'user' => [
                    'id' => $user->id(),
                    'name' => $user->name(),
                    'email' => $user->email(),
                    'registered_datetime' => $user->registeredDatetime(),
                ],
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());

            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }

        return $response;
    }
}
