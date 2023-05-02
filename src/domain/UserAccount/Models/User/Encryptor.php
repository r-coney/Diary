<?php
namespace Domain\UserAccount\Models\User;

interface Encryptor
{
    /**
     * 文字列をハッシュ化
     *
     * @param string $string
     * @return string
     */
    public function encrypt(string $string): string;
}
