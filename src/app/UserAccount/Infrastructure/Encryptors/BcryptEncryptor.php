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
}
