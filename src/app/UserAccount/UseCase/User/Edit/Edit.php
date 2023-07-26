<?php
namespace App\UserAccount\UseCase\User\Edit;

use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use App\UserAccount\Result;
use App\UserAccount\UseCase\User\Edit\EditCommandInterface;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class Edit implements EditInterface
{
    private UserRepositoryInterface $userRepository;
    private Encryptor $encryptor;

    public function __construct(
        UserRepositoryInterface $userRepository,
        Encryptor $encryptor
    ) {
        $this->userRepository = $userRepository;
        $this->encryptor = $encryptor;
    }

    public function __invoke(EditCommandInterface $command): Result
    {
        try {
            $editedUser = DB::transaction(function () use ($command) {
                $user = $this->userRepository->find(new Id($command->userId()));

                if (!$user->verifyPassword($this->encryptor, new Password($command->currentPassword()))) {
                    throw new InvalidArgumentException('Password does not match');
                }

                if ($command->hasNewName()) {
                    $user->changeName(new Name($command->newName()));
                }

                if ($command->hasNewEmail()) {
                    $user->changeEmail(new Email($command->newEmail()));
                }

                if ($command->hasNewPassword()) {
                    if ($command->newPassword() !== $command->newPasswordConfirmation()) {
                        throw new InvalidArgumentException('New password does not match confirmation password');
                    }

                    $newPassword = new Password($command->newPassword());
                    $user->changePassword($newPassword->encrypt($this->encryptor));
                }
                $editedUser = $this->userRepository->save($user);

                return $editedUser;
            });

            $result = Result::ofValue($editedUser);
        } catch (InvalidArgumentException $e) {
            $result = Result::ofError($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result = Result::ofError($e->getMessage());
        }

        return $result;
    }
}
