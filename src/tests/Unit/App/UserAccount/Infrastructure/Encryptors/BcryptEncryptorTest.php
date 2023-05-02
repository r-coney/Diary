<?php

namespace Tests\Unit\App\UserAccount\Infrastructure\Encryptors;

use PHPUnit\Framework\TestCase;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;

class BcryptEncryptorTest extends TestCase
{
    /**
     * @test
     */
    public function 文字列がハッシュ化されること()
    {
        $encryptor = new BcryptEncryptor();
        $string = 'test123';

        $hashedString = $encryptor->encrypt($string);

        $this->assertNotEquals($string, $hashedString);
        $this->assertTrue(password_verify($string, $hashedString));
    }
}
