<?php

namespace App\Providers\DiaryApp;

use Illuminate\Support\ServiceProvider;
use App\DiaryApp\UseCase\Diary\Create\CreateInterface as CreateDiaryInterface;
use App\DiaryApp\UseCase\Diary\Create\Create as CreateDiary;
use App\DiaryApp\UseCase\Diary\Create\CreateCommandInterface as CreateDiaryCommandInterface;
use App\DiaryApp\UseCase\Diary\Create\CreateCommand as CreateDiaryCommand;
use App\DiaryApp\UseCase\Diary\GetList\GetListInterface as GetDiaryListInterface;
use App\DiaryApp\UseCase\Diary\GetList\GetList as GetDiaryList;
use App\DiaryApp\UseCase\Diary\GetList\DiaryListQueryDataInterface;
use App\DiaryApp\UseCase\Diary\GetList\DiaryListQueryData;
use App\DiaryApp\UseCase\Diary\GetDetail\GetDetailInterface as GetDiaryDetailInterface;
use App\DiaryApp\UseCase\Diary\GetDetail\GetDetail as GetDiaryDetail;
use App\DiaryApp\UseCase\Diary\Edit\EditInterface as EditDiaryInterface;
use App\DiaryApp\UseCase\Diary\Edit as EditDiary;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CreateDiaryInterface::class, CreateDiary::class);
        $this->app->bind(CreateDiaryCommandInterface::class, CreateDiaryCommand::class);
        $this->app->bind(GetDiaryListInterface::class, GetDiaryList::class);
        $this->app->bind(DiaryListQueryDataInterface::class, DiaryListQueryData::class);
        $this->app->bind(GetDiaryDetailInterface::class, GetDiaryDetail::class);
        $this->app->bind(EditDiaryInterface::class, EditDiary::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
