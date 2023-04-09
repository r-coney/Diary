<?php

namespace App\Providers\DiaryApp;

use Illuminate\Support\ServiceProvider;
use App\DiaryApp\UseCase\Diary\Create\Create;
use App\DiaryApp\UseCase\Diary\GetList\GetList;
use App\DiaryApp\UseCase\Diary\Create\CreateCommand;
use App\DiaryApp\UseCase\Diary\Create\CreateInterface;
use App\DiaryApp\UseCase\Diary\GetList\GetListInterface;
use App\DiaryApp\UseCase\Diary\Create\CreateCommandInterface;
use App\DiaryApp\UseCase\Diary\GetList\DiaryListQueryData;
use App\DiaryApp\UseCase\Diary\GetList\DiaryListQueryDataInterface;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CreateInterface::class, Create::class);
        $this->app->bind(CreateCommandInterface::class, CreateCommand::class);
        $this->app->bind(GetListInterface::class, GetList::class);
        $this->app->bind(DiaryListQueryDataInterface::class, DiaryListQueryData::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
