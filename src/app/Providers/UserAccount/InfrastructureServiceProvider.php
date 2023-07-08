<?php

namespace App\Providers\UserAccount;

use Illuminate\Support\ServiceProvider;
use Domain\UserAccount\Models\User\Encryptor;
use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;
use App\UserAccount\Infrastructure\InMemory\Repositories\UserRepository as InMemoryUserRepository;
use App\UserAccount\UseCase\User\QueryServiceInterface as UserQueryServiceInterface;
use App\UserAccount\Infrastructure\InMemory\Queries\UserQueryService;
use App\UserAccount\Infrastructure\Services\AccessTokenService;
use App\UserAccount\Infrastructure\Services\AccessTokenServiceInterface;

class InfrastructureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, InMemoryUserRepository::class);
        $this->app->bind(Encryptor::class, BcryptEncryptor::class);
        $this->app->bind(UserQueryServiceInterface::class, UserQueryService::class);
        $this->app->bind(AccessTokenServiceInterface::class, AccessTokenService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
