<?php
namespace App\UserAccount\Infrastructure\Encryptors;

use Domain\UserAccount\Models\User\Encryptor;

class BcryptEncryptor implements Encryptor
{
    /**
     * 文字列をハッシュ化
     *
     * @param string $string
     * @return string
     */
    public function encrypt(string $string): string
    {
        return password_hash($string, PASSWORD_BCRYPT);
    }

    /**
     * 文字列とハッシュ化された文字列が一致するか検証
     *
     * @param string $string
     * @param string $encryptedString
     * @return bool
     */
    public function verify(string $string, string $encryptedString): bool
    {
        return password_verify($string, $encryptedString);
    }
}
