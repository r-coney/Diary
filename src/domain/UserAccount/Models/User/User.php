<?php
namespace Domain\UserAccount\Models\User;

use DateTime;
use Domain\UserAccount\Models\Entity;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\EncryptedPassword;

class User implements Entity
{
    private Id $id;
    private Name $name;
    private Email $email;
    private EncryptedPassword $password;
    private DateTime $registeredDateTime;
    private ?DateTime $updatedDateTime;
    private ?DateTime $deletedDateTime;

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
    public function updatedDateTime(): string
    {
        return $this->updatedDateTime->format('Y-m-d H:i:s');
    }

    /**
     * 削除日時を取得
     *
     * @return string
     */
    public function deletedDateTime(): string
    {
        return $this->deletedDateTime->format('Y-m-d H:i:s');
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
     * @param Password $password
     * @return void
     */
    public function changePassword(Password $password): void
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
