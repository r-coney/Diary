<?php
namespace App\UserAccount\Infrastructure\InMemory\Repositories;

use DateTime;
use Illuminate\Support\Facades\Cache;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\FactoryInterface as UserFactoryInterface;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private UserFactoryInterface $userFactory;
    private array $store;

    public function __construct(
        UserFactoryInterface $userFactory
    ) {
        $this->userFactory = $userFactory;
        $this->store = Cache::get('users', []);
    }

    public function store(): array
    {
        $this->store = Cache::get('users', []);

        return $this->store;
    }

    public function save(User $user): void
    {
        $store = $this->store();

        foreach ($store as $index => $entity) {
            if ($user->id() === $entity->id) {
                unset($store[$index]);
            }
        }

        $store[] = (object) [
            'id' => $user->id(),
            'name' => $user->name(),
            'email' => $user->email(),
            'password' => $user->password(),
            'created_at' => $user->registeredDateTime(),
            'updated_at' => $user->updatedDateTime(),
            'deleted_at' => $user->deletedDateTime()
        ];
    }

    public function find(Id $id): ?User
    {
        foreach ($this->store as $entity) {
            if ($id->value() === $entity->id) {
                return $this->userFactory->create(
                    new Name($entity->name),
                    new Email($entity->email),
                    new Password($entity->password),
                    new DateTime($entity->created_at),
                    isset($entity->updated_at) ? new DateTime($entity->updated_at) : null,
                    isset($entity->deleted_at) ? new DateTime($entity->deleted_at) : null,
                    new Id($entity->id),
                );
            }
        }

        return null;
    }

    public function findByEmail(Email $email): ?User
    {
        foreach ($this->store as $entity) {
            if ($email->value() === $entity->email) {
                return $this->userFactory->create(
                    new Name($entity->name),
                    new Email($entity->email),
                    new Password($entity->password),
                    new DateTime($entity->created_at),
                    isset($entity->updated_at) ? new DateTime($entity->updated_at) : null,
                    isset($entity->deleted_at) ? new DateTime($entity->deleted_at) : null,
                    new Id($entity->id),
                );
            }
        }

        return null;
    }
}
