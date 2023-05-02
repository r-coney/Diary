<?php
namespace Domain\UserAccount\Models\User;

use DateTime;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Models\User\FactoryInterface;

class Factory implements FactoryInterface
{
    private Encryptor $encryptor;

    public function __construct(
        Encryptor $encryptor
    ) {
        $this->encryptor = $encryptor;
    }

    public function create(
        Name $name,
        Email $email,
        Password $password,
        DateTime $registeredDateTime,
        DateTime $updatedDateTime = null,
        DateTime $deletedDateTime = null,
        Id $id = null
    ): User {
        if (is_null($id)) {
            $id = $this->getNextSequenceNumber();
        }

        return new User(
            $id,
            $name,
            $email,
            $password->encrypt($this->encryptor),
            $registeredDateTime,
            $updatedDateTime,
            $deletedDateTime,
        );
    }

    /**
     * シーケンスIDを取得
     *
     * @return Id
     */
    private function getNextSequenceNumber(): Id
    {
        $lastNumber = DB::connection('sequence_db')
            ->table('sequences')
            ->where('entity', 'user')
            ->lockForUpdate()
            ->first();

        if (is_null($lastNumber)) {
            $lastNumber = new stdClass();
            $lastNumber->id = 0;
        }

        $newNumber = $lastNumber->id + 1;

        DB::transaction(function () use ($newNumber) {
            DB::connection('sequence_db')
                ->table('sequences')
                ->updateOrInsert(
                    ['entity' => 'diary'],
                    ['id' => $newNumber],
                );
        });

        return new Id($newNumber);
    }
}
