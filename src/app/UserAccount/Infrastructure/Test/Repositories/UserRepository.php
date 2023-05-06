<?php
namespace App\UserAccount\Infrastructure\Test\Repositories;

use DateTime;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\FactoryInterface;
use Domain\UserAccount\Models\User\EncryptedPassword;
use Domain\UserAccount\Models\User\RepositoryInterface;

class UserRepository implements RepositoryInterface
{
    private array $store = [];
    private FactoryInterface $userFactory;

    public function __construct(
        FactoryInterface $userFactory
    ) {
        $this->userFactory = $userFactory;
    }

    public function store(): array
    {
        return $this->store;
    }

    public function find(Id $id): ?User
    {
        foreach ($this->store as $entity) {
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
        foreach ($this->store as $entity) {
            if ($email->value() === $entity->email) {
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

    public function save(User $user): void
    {
        foreach ($this->store as $index => $entity) {
            if ($user->id() === $entity->id) {
                unset($this->store[$index]);
            }
        }

        $this->store[] = (object) [
            'id' => $user->id(),
            'name' => $user->name(),
            'email' => $user->email(),
            'password' => $user->password(),
            'created_at' => $user->registeredDateTime(),
            'updated_at' => $user->updatedDateTime(),
            'deleted_at' => $user->deletedDateTime()
        ];
    }
}