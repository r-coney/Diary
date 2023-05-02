<?php

namespace App\Providers\UserAccount;

use Domain\UserAccount\Models\User\FactoryInterface as UserFactoryInterface;
use Domain\UserAccount\Models\User\InMemoryFactory as InMemoryUserFactory;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserFactoryInterface::class, InMemoryUserFactory::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
