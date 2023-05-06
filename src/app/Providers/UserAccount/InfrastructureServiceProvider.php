<?php

namespace App\Providers\UserAccount;

use App\UserAccount\Infrastructure\Encryptors\BcryptEncryptor;
use Illuminate\Support\ServiceProvider;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;
use App\UserAccount\Infrastructure\InMemory\Repositories\UserRepository as InMemoryUserRepository;
use Domain\UserAccount\Models\User\Encryptor;

class InfrastructureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, InMemoryUserRepository::class);
        $this->app->bind(Encryptor::class, BcryptEncryptor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
