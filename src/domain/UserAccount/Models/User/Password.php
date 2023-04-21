<?php
namespace Domain\UserAccount\Models\User;

use Domain\UserAccount\Models\ValueObject;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Exceptions\User\InvalidPasswordException;

class Password implements ValueObject
{
    private string $value;

    public function __construct(string $password)
    {
        if ($this->hasFullWidthCharacters($password)) {
            throw new InvalidPasswordException('パスワードに全角文字が含まれています');
        }

        if (!$this->hasNumericAndLowercase($password)) {
            throw new InvalidPasswordException('パスワードには数字と小文字を含めてください');
        }

        if (strlen($password) < 8) {
            throw new InvalidPasswordException('パスワードは8文字以上で入力してください');
        }

        $this->value = $password;
    }

    private function hasFullWidthCharacters(string $password): bool
    {
        return preg_match('/[^\p{ASCII}]/u', $password);
    }

    private function hasNumericAndLowercase(string $password): bool
    {
        return preg_match('/^(?=.*\d)(?=.*[a-z]).+$/', $password);
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * パスワードをハッシュ化
     *
     * @param Encryptor $encryptor
     * @return EncryptedPassword
     */
    public function encrypt(Encryptor $encryptor): EncryptedPassword
    {
        return new EncryptedPassword($encryptor->encrypt($this->value));
    }

    public function equals(?ValueObject $other): bool
    {
        if (is_null($other)) {
            return false;
        }

        if ($this === $other) {
            return true;
        }

        return $this->value() === $other->value();
    }
}
