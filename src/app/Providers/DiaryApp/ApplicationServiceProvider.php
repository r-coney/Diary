<?php

namespace App\Providers\DiaryApp;

use App\DiaryApp\UseCase\Diary\Create\Create;
use App\DiaryApp\UseCase\Diary\Create\CreateCommand;
use App\DiaryApp\UseCase\Diary\Create\CreateCommandInterface;
use App\DiaryApp\UseCase\Diary\Create\CreateInterface;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CreateInterface::class, Create::class);
        $this->app->bind(CreateCommandInterface::class, CreateCommand::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
