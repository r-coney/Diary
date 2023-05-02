<?php

namespace App\Providers\UserAccount;

use App\UserAccount\UseCase\User\Register\RegisterInterface as RegisterUserInterface;
use App\UserAccount\UseCase\User\Register\Register as RegisterUser;
use App\UserAccount\UseCase\User\GetDetail\GetDetailInterface as GetUserDetailInterface;
use App\UserAccount\UseCase\User\GetDetail\GetDetail as GetUserDetail;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RegisterUserInterface::class, RegisterUser::class);
        $this->app->bind(GetUserDetailInterface::class, GetUserDetail::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
