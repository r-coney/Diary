<?php

namespace Tests\Unit\App\UserAccount\Infrastructure\Services;

use DateTime;
use Tests\TestCase;
use App\Models\AccessToken;
use App\UserAccount\Infrastructure\Services\AccessTokenService;
use App\UserAccount\Infrastructure\AccessTokenRepositoryInterface;
use App\UserAccount\Infrastructure\Test\Repositories\AccessTokenRepository;
use Domain\UserAccount\Models\User\User;
use Domain\UserAccount\Models\User\Id as UserId;
use Domain\UserAccount\Models\User\Name;
use Domain\UserAccount\Models\User\Email;
use Domain\UserAccount\Models\User\EncryptedPassword;

class AccessTokenServiceTest extends TestCase
{
    private AccessTokenRepositoryInterface $accessTokenRepository;
    private AccessTokenService $accessTokenService;
    private User $registeredUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->accessTokenRepository = new AccessTokenRepository();
        $this->accessTokenService = new AccessTokenService($this->accessTokenRepository);
        $this->registeredUser = new User(
            id: new UserId(1),
            name: new Name('test'),
            email: new Email('test@example.com'),
            password: new EncryptedPassword('password1'),
            registeredDateTime: new DateTime()
        );
    }

    /**
     * @test
     * generate()
     */
    public function アクセストークンが作成されること(): void
    {
        $accessToken = $this->accessTokenService->generate($this->registeredUser);

        $this->assertInstanceOf(AccessToken::class, $accessToken);
        $this->assertIsString($accessToken->token);
    }

    /**
     * @test
     * generate()
     */
    public function 作成したアクセストークンが保存されていること(): void
    {
        $accessToken = $this->accessTokenService->generate($this->registeredUser);
        $savedAccessToken = $this->accessTokenRepository->findByUserId(new UserId($this->registeredUser->id()));

        $this->assertSame($accessToken->token, $savedAccessToken->token);
    }

    /**
     * @test
     * generate()
     */
    public function 作成したアクセストークンの有効期限が1日後に設定されていること(): void
    {
        $accessToken = $this->accessTokenService->generate($this->registeredUser);
        $this->assertSame($accessToken->expires_at->format('Y-m-d'), date('Y-m-d', strtotime('+1 day')));
    }

    /**
     * @test
     * authentication()
     */
    public function 有効なトークンで認証に成功した場合trueを返すこと(): void
    {
        $accessToken = new AccessToken([
            'user_id' => $this->registeredUser->id(),
            'token' => 'token',
            'expires_at' => date('Y-m-d', strtotime('+1 day')),
        ]);
        $this->accessTokenRepository->save($accessToken);

        $this->assertTrue($this->accessTokenService->authentication(accessToken: $accessToken, requestedToken: $accessToken->token));
    }


    /**
     * @test
     * authentication()
     */
    public function 無効なトークンで認証に失敗した場合falseを返すこと(): void
    {
        $accessToken = new AccessToken([
            'user_id' => $this->registeredUser->id(),
            'token' => 'token',
            'expires_at' => date('Y-m-d', strtotime('+1 day')),
        ]);
        $this->accessTokenRepository->save($accessToken);

        $this->assertFalse($this->accessTokenService->authentication(accessToken: $accessToken, requestedToken: 'invalid token'));
    }


    /**
     * @test
     * authentication()
     */
    public function トークンの有効期限が切れている場合falseを返すこと(): void
    {
        $accessToken = new AccessToken([
            'user_id' => $this->registeredUser->id(),
            'token' => 'token',
            'expires_at' => date('Y-m-d', strtotime('-1 day')),
        ]);
        $this->accessTokenRepository->save($accessToken);

        $this->assertFalse($this->accessTokenService->authentication(accessToken: $accessToken, requestedToken: $accessToken->token));
    }
}
