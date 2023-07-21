<?php
namespace App\UserAccount\UseCase\User\Register;

use DateTime;
use Exception;
use RuntimeException;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\UserAccount\User\UseCase\CanNotRegisterUserException;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Services\UserService;
use Domain\UserAccount\Models\User\FactoryInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

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

    public function __invoke(RegisterCommandInterface $registerCommand): User
    {
        try {
            if ($registerCommand->password() !== $registerCommand->passwordConfirmation()) {
                throw new InvalidArgumentException('Password does not match');
            }

            $registeredUser = DB::transaction(function () use ($registerCommand) {
                $user = $this->userFactory->create(
                    new Name($registerCommand->name()),
                    new Email($registerCommand->email()),
                    new Password($registerCommand->password()),
                    new DateTime(),
                );

                if ($this->UserService->exists($user)) {
                    throw new InvalidArgumentException('Users already exist.');
                }

                $registeredUser = $this->userRepository->save($user);
                if (is_null($registeredUser)) {
                    throw new RuntimeException('Failed to save user account.');
                }

                return $registeredUser;
            });

            // $response = [
            //     'status' => 'success',
            //     'user' => [
            //         'id' => $user->id(),
            //         'name' => $user->name(),
            //         'email' => $user->email(),
            //         'registered_datetime' => $user->registeredDatetime(),
            //     ],
            // ];
        } catch (Exception $e) {
            throw new CanNotRegisterUserException($e, 400);
        }

        return $registeredUser;
    }
}
