<?php

namespace App\Providers\UserAccount;

use Illuminate\Support\ServiceProvider;
use Domain\UserAccount\Models\User\RepositoryInterface as UserRepositoryInterface;
use App\UserAccount\Infrastructure\InMemory\Repositories\UserRepository as InMemoryUserRepository;

class InfrastructureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, InMemoryUserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
