<?php
namespace App\UserAccount\UseCase\User\Register;

use App\Exceptions\DiaryApp\Diary\UseCase\CanNotCreateDiaryException;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Exceptions\UserAccount\User\UseCase\CanNotRegisterUserException;
use App\UserAccount\Result;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Services\UserService;
use Domain\UserAccount\Models\User\FactoryInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;
use InvalidArgumentException;

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

    public function __invoke(RegisterCommandInterface $registerCommand): Result
    {
        try {
            if ($registerCommand->password() !== $registerCommand->passwordConfirmation()) {
                throw new InvalidArgumentException('Password does not match.');
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
                    throw new CanNotRegisterUserException('Failed to save user account.');
                }

                return $registeredUser;
            });

            $result = Result::ofValue($registeredUser);
        } catch (InvalidArgumentException $e) {
            $result = Result::ofError($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result = Result::ofError($e->getMessage());
        }

        return $result;
    }
}
