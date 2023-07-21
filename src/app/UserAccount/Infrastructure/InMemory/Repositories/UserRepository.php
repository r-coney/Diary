<?php
namespace App\UserAccount\Infrastructure\InMemory\Repositories;

use DateTime;
use Illuminate\Support\Facades\Cache;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\EncryptedPassword;
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

    public function save(User $user): User
    {
        $store = $this->store();

        foreach ($store as $index => $entity) {
            if ($user->id() === $entity->id) {
                unset($store[$index]);
            }
        }

        // $user = $this->userFactory->create(
        //     name: new Name($user->name()),
        //     email: new Email($user->email()),
        //     password: new Password($user->password()),
        //     registeredDateTime: $user->registeredDateTime() ? new DateTime($user->registeredDateTime()) : null,
        //     updatedDateTime: $user->updatedDateTime() ? new DateTime($user->updatedDateTime()) : null,
        //     deletedDateTime: $user->deletedDateTime() ? new Datetime($user->deletedDateTime()) : null,
        //     id: $user->id() ? new Id($user->id()) : null
        // );

        $store[] = (object) [
            'id' => $user->id(),
            'name' => $user->name(),
            'email' => $user->email(),
            'password' => $user->password(),
            'created_at' => $user->registeredDateTime(),
            'updated_at' => $user->updatedDateTime(),
            'deleted_at' => $user->deletedDateTime()
        ];
        Cache::put('users', $store);

        return $user;
    }

    public function find(Id $id): ?User
    {
        foreach ($this->store() as $entity) {
            if ($id->value() === $entity->id) {
                return $this->userFactory->create(
                    new Name($entity->name),
                    new Email($entity->email),
                    new EncryptedPassword($entity->password),
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
        foreach ($this->store() as $entity) {
            if ($email->value() === $entity->email && is_null($entity->deleted_at)) {
                return $this->userFactory->create(
                    new Name($entity->name),
                    new Email($entity->email),
                    new EncryptedPassword($entity->password),
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
