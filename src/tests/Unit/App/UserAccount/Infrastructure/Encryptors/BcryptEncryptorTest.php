<?php

namespace Tests\Unit\App\UserAccount\Infrastructure\Encryptors;

use Tests\TestCase;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use Domain\UserAccount\Models\User\Encryptor;

class BcryptEncryptorTest extends TestCase
{
    private Encryptor $encryptor;

    public function setUp(): void
    {
        $this->encryptor = new BcryptEncryptor();
    }

    /**
     * @test
     */
    public function 文字列がハッシュ化されること()
    {
        $string = 'test123';

        $hashedString = $this->encryptor->encrypt($string);

        $this->assertNotEquals($string, $hashedString);
        $this->assertTrue(password_verify($string, $hashedString));
    }

    /**
     * verify()
     * @test
     */
    public function 文字列とハッシュ化された文字列が一致するか検証できること()
    {
        $password = 'password1';
        $otherPassword = 'otherPassword1';
        $encryptedPassword = $this->encryptor->encrypt($password);

        $this->assertTrue($this->encryptor->verify($password, $encryptedPassword));
        $this->assertFalse($this->encryptor->verify($otherPassword, $encryptedPassword));
    }
}
