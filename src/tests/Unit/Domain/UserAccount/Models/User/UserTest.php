<?php
namespace Tests\Unit\Domain\UserAccount\Models\User;

use DateTime;
use Tests\TestCase;
use Domain\UserAccount\Models\User\Id;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\Password;
use Domain\UserAccount\Models\User\Encryptor;
use Domain\UserAccount\Models\User\EncryptedPassword;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;

class UserTest extends TestCase
{
    private Encryptor $encryptor;

    public function setUp(): void
    {
        parent::setUp();

        $this->encryptor = new BcryptEncryptor();
    }

    /**
     * id()
     * @test
     */
    public function IDを取得できること(): void
    {
        $id = new Id(1);
        $user = new User(
            $id,
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime()
        );

        $this->assertSame($id->value(), $user->id());
    }

    /**
     * name()
     * @test
     */
    public function 名前を取得できること(): void
    {
        $name = new Name('test');
        $user = new User(
            new Id(1),
            $name,
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime()
        );

        $this->assertSame($name->value(), $user->name());
    }

    /**
     * email()
     * @test
     */
    public function emailを取得できること(): void
    {
        $email = new Email('test@example.com');
        $user = new User(
            new Id(1),
            new Name('test'),
            $email,
            new EncryptedPassword('password'),
            new DateTime()
        );

        $this->assertSame($email->value(), $user->email());
    }

    /**
     * password()
     * @test
     */
    public function パスワードを取得できること(): void
    {
        $password = new EncryptedPassword('password');
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            $password,
            new DateTime(),
        );

        $this->assertSame($password->value(), $user->password());
    }

    /**
     * registeredDateTime()
     * @test
     */
    public function 登録日時を取得できること(): void
    {
        $registeredDateTime = new DateTime();
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime(),
        );

        $this->assertSame($registeredDateTime->format('Y-m-d H:i:s'), $user->registeredDateTime());
    }

    /**
     * updatedDateTime()
     * @test
     */
    public function  更新日時を取得できること(): void
    {
        $updatedDateTime = new DateTime();
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime(),
            $updatedDateTime
        );

        $this->assertSame($updatedDateTime->format('Y-m-d H:i:s'), $user->updatedDateTime());
    }

    /**
     * deletedDateTime()
     * @test
     */
    public function 削除日時を取得できること(): void
    {
        $deletedDateTime = new DateTime();
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime(),
            new DateTime(),
            $deletedDateTime
        );

        $this->assertSame($deletedDateTime->format('Y-m-d H:i:s'), $user->deletedDateTime());
    }

    /**
     * changeName()
     * @test
     */
    public function 名前を変更できる(): void
    {
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime()
        );

        $expectedName = new Name('test2');
        $user->changeName($expectedName);

        $this->assertSame($expectedName->value(), $user->name());
    }

    /**
     * changeEmail()
     * @test
     */
    public function メールアドレスを変更できる(): void
    {
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime()
        );

        $expectedEmail = new Email('test2@example.com');
        $user->changeEmail($expectedEmail);

        $this->assertSame($expectedEmail->value(), $user->email());
    }

    /**
     * changePassword()
     * @test
     */
    public function パスワードを変更できる(): void
    {
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime()
        );

        $expectedPassword = new EncryptedPassword('password2');
        $user->changePassword($expectedPassword);

        $this->assertSame($expectedPassword->value(), $user->password());
    }

    /**
     * verifyPassword()
     * @test
     */
    public function パスワードの認証ができること(): void
    {
        $password = new Password('password1');
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            $password->encrypt($this->encryptor),
            new DateTime()
        );

        $this->assertTrue($user->verifyPassword($this->encryptor, $password->value()));
    }

    /**
     * changeDeletedDateTime()
     * @test
     */
    public function 削除日時を変更できる(): void
    {
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime()
        );

        $expectedDeletedDateTime = new DateTime();
        $user->changeDeletedDateTime(new DateTime());

        $this->assertSame($expectedDeletedDateTime->format('Y-m-d H:i:s'), $user->deletedDateTime());
    }

    /**
     * equals()
     * @test
     */
    public function Entity同士を比較できる(): void
    {
        $user = new User(
            new Id(1),
            new Name('test'),
            new Email('test@example.com'),
            new EncryptedPassword('password'),
            new DateTime()
        );

        $this->assertTrue($user->equals($user));
        $this->assertFalse($user->equals(null));
    }
}
