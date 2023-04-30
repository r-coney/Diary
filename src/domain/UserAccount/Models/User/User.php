<?php
namespace Domain\UserAccount\Models\User;

use DateTime;
use Domain\UserAccount\Models\Entity;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\EncryptedPassword;
use InvalidArgumentException;

class User implements Entity
{
    private Id $id;
    private Name $name;
    private Email $email;
    private EncryptedPassword $password;
    private DateTime $registeredDateTime;
    private ?DateTime $updatedDateTime;
    private ?DateTime $deletedDateTime;

    public function __construct(
        Id $id,
        Name $name,
        Email $email,
        EncryptedPassword $password,
        DateTime $registeredDateTime,
        ?DateTime $updatedDateTime = null,
        ?DateTime $deletedDateTime = null
    ) {
        if (is_null($id)) {
            throw new InvalidArgumentException('IDは必須です');
        }

        if (is_null($name)) {
            throw new InvalidArgumentException('名前は必須です');
        }

        if (is_null($email)) {
            throw new InvalidArgumentException('メールアドレスは必須です');
        }

        if (is_null($password)) {
            throw new InvalidArgumentException('パスワードは必須です');
        }

        if (is_null($registeredDateTime)) {
            throw new InvalidArgumentException('登録日時は必須です');
        }

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->registeredDateTime = $registeredDateTime;
        $this->updatedDateTime = $updatedDateTime;
        $this->deletedDateTime = $deletedDateTime;
    }

    public function id(): int
    {
        return $this->id->value();
    }

    /**
     * 名前を取得
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name->value();
    }

    /**
     * メールアドレスを取得
     *
     * @return string
     */
    public function email(): string
    {
        return $this->email->value();
    }

    /**
     * ハッシュ化されたパスワードを取得
     *
     * @return string
     */
    public function password(): string
    {
        return $this->password->value();
    }

    /**
     * 登録日時を取得
     *
     * @return string
     */
    public function registeredDateTime(): string
    {
        return $this->registeredDateTime->format('Y-m-d H:i:s');
    }

    /**
     * 更新日時を取得
     *
     * @return string
     */
    public function updatedDateTime(): ?string
    {
        return isset($this->updatedDateTime) ? $this->updatedDateTime->format('Y-m-d H:i:s') : null;
    }

    /**
     * 削除日時を取得
     *
     * @return string
     */
    public function deletedDateTime(): ?string
    {
        return isset($this->deletedDateTime) ? $this->deletedDateTime->format('Y-m-d H:i:s') : null;
    }

    /**
     * 与えられたパスワードが、ユーザーのパスワードと一致するかどうかを判定
     *
     * @param EncryptedPassword $password
     * @return bool
     */
    public function authenticate(EncryptedPassword $password): bool
    {
        return $this->password->equals($password);
    }

    /**
     * 名前を変更
     *
     * @param Name $name
     * @return void
     */
    public function changeName(Name $name): void
    {
        $this->name = $name;
        $this->changeUpdateDateTime();
    }

    /**
     * メールアドレスを変更
     *
     * @param Email $email
     * @return void
     */
    public function changeEmail(Email $email): void
    {
        $this->email = $email;
        $this->changeUpdateDateTime();
    }

    /**
     * パスワードを変更
     *
     * @param EncryptedPassword $password
     * @return void
     */
    public function changePassword(EncryptedPassword $password): void
    {
        $this->password = $password;
        $this->changeUpdateDateTime();
    }

    /**
     * 更新日時を変更
     *
     * @return void
     */
    public function changeUpdateDateTime(): void
    {
        $this->updatedDateTime = new DateTime();
    }

    /**
     * 削除日時を変更
     *
     * @return void
     */
    public function changeDeletedDateTime(): void
    {
        $this->deletedDateTime = new DateTime();
        $this->changeUpdateDateTime();
    }

    public function equals(?Entity $other): bool
    {
        if (is_null($other)) {
            return false;
        }

        if ($this === $other) {
            return true;
        }

        return $this->id === $other->id();
    }
}
