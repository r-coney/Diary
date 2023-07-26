<?php

namespace App\Providers\UserAccount;

use Illuminate\Support\ServiceProvider;
use App\UserAccount\UseCase\User\Login\Login;
use App\UserAccount\UseCase\User\Logout\Logout;
use App\UserAccount\UseCase\User\Login\LoginInterface;
use App\UserAccount\UseCase\User\Edit\Edit as EditUser;
use App\UserAccount\UseCase\User\Logout\LogoutInterface;
use App\UserAccount\UseCase\User\Delete\Delete as DeleteUser;
use App\UserAccount\UseCase\User\GetList\GetList as GetUserList;
use App\UserAccount\UseCase\User\Register\Register as RegisterUser;
use App\UserAccount\UseCase\User\VerifyAccessToken\VerifyAccessToken;
use App\UserAccount\UseCase\User\GetDetail\GetDetail as GetUserDetail;
use App\UserAccount\UseCase\User\Edit\EditInterface as EditUserInterface;
use App\UserAccount\UseCase\User\VerifyAccessToken\VerifyAccessTokenInterface;
use App\UserAccount\UseCase\User\Delete\DeleteInterface as DeleteUserInterface;
use App\UserAccount\UseCase\User\GetList\GetListInterface as GetUserListInterface;
use App\UserAccount\UseCase\User\Register\RegisterInterface as RegisterUserInterface;
use App\UserAccount\UseCase\User\GetDetail\GetDetailInterface as GetUserDetailInterface;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RegisterUserInterface::class, RegisterUser::class);
        $this->app->bind(GetUserListInterface::class, GetUserList::class);
        $this->app->bind(GetUserDetailInterface::class, GetUserDetail::class);
        $this->app->bind(EditUserInterface::class, EditUser::class);
        $this->app->bind(DeleteUserInterface::class, DeleteUser::class);
        $this->app->bind(LoginInterface::class, Login::class);
        $this->app->bind(VerifyAccessTokenInterface::class, VerifyAccessToken::class);
        $this->app->bind(LogoutInterface::class, Logout::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
