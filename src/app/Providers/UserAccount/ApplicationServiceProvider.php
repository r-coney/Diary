<?php

namespace App\Providers\UserAccount;

use Illuminate\Support\ServiceProvider;
use App\UserAccount\UseCase\User\Delete\Delete as DeleteUser;
use App\UserAccount\UseCase\User\Delete\DeleteInterface as DeleteUserInterface;
use App\UserAccount\UseCase\User\Register\RegisterInterface as RegisterUserInterface;
use App\UserAccount\UseCase\User\Register\Register as RegisterUser;
use App\UserAccount\UseCase\User\Edit\Edit as EditUser;
use App\UserAccount\UseCase\User\Edit\EditInterface as EditUserInterface;
use App\UserAccount\UseCase\User\GetDetail\GetDetail as GetUserDetail;
use App\UserAccount\UseCase\User\GetDetail\GetDetailInterface as GetUserDetailInterface;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RegisterUserInterface::class, RegisterUser::class);
        $this->app->bind(GetUserDetailInterface::class, GetUserDetail::class);
        $this->app->bind(EditUserInterface::class, EditUser::class);
        $this->app->bind(DeleteUserInterface::class, DeleteUser::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
