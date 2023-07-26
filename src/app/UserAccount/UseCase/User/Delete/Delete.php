<?php
namespace App\UserAccount\UseCase\User\Delete;

use DateTime;
use Exception;
use App\UserAccount\UseCase\User\Delete\DeleteInterface;
use App\Exceptions\UserAccount\User\UseCase\UserNotFoundException;
use App\UserAccount\Result;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class Delete implements DeleteInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(Id $id): Result
    {
        $user = $this->userRepository->find($id);

        try {
            if (is_null($user)) {
                throw new UserNotFoundException('User not found. ID: ' . $id->value());
            }

            $deletedUser = DB::transaction(function () use ($user) {
                $user->changeDeletedDateTime(new DateTime());
                return $this->userRepository->save($user);
            });

            $result = Result::ofValue($deletedUser);
        } catch (UserNotFoundException $e) {
            $result = Result::ofError($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result = Result::ofError($e->getMessage());
        }

        return $result;
    }
}
