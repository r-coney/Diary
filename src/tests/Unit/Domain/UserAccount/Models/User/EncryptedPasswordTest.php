<?php

namespace Tests\Unit\Domain\UserAccount\Models\User;

use Tests\TestCase;
use Domain\UserAccount\Models\User\EncryptedPassword;

class EncryptedPasswordTest extends TestCase
{
    /**
     * @test
     */
    public function パスワードが正常に設定されること()
    {
        $password = new EncryptedPassword('$2y$10$0Ew1CLvGcNtRQzBZg4B.eO9ij.SfKpAq3RoMtS8rlC26NvTzLOZKy');

        $this->assertEquals('$2y$10$0Ew1CLvGcNtRQzBZg4B.eO9ij.SfKpAq3RoMtS8rlC26NvTzLOZKy', $password->value());
    }

    /**
     * equals()
     * @test
     */
    public function 同じ値のパスワードが等しいこと()
    {
        $password1 = new EncryptedPassword('$2y$10$0Ew1CLvGcNtRQzBZg4B.eO9ij.SfKpAq3RoMtS8rlC26NvTzLOZKy');
        $password2 = new EncryptedPassword('$2y$10$0Ew1CLvGcNtRQzBZg4B.eO9ij.SfKpAq3RoMtS8rlC26NvTzLOZKy');

        $this->assertTrue($password1->equals($password2));
    }

    /**
     * equals()
     * @test
     */
    public function 異なる値のパスワードが等しくないこと()
    {
        $password1 = new EncryptedPassword('$2y$10$0Ew1CLvGcNtRQzBZg4B.eO9ij.SfKpAq3RoMtS8rlC26NvTzLOZKy');
        $password2 = new EncryptedPassword('$2y$10$hD/6iJwPfA8V7srU6a.LUe7fN6QsFyDOKhJ67EgIz0vxQOFY8UEwm');

        $this->assertFalse($password1->equals($password2));
    }
}
