<?php

namespace App\Providers\UserAccount;

use App\UserAccount\UseCase\User\Register\RegisterInterface as RegisterUserInterface;
use App\UserAccount\UseCase\User\Register\Register as RegisterUser;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RegisterUserInterface::class, RegisterUser::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
