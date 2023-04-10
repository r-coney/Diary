<?php

namespace App\Providers\DiaryApp;

use App\DiaryApp\UseCase\Diary\QueryServiceInterface as DiaryQueryServiceInterface;
use App\DiaryApp\Infrastructure\InMemory\Queries\DiaryQueryService as InMemoryDiaryQueryService;
use App\DiaryApp\Infrastructure\InMemory\Repositories\DiaryRepository as InMemoryDiaryRepository;
use Domain\DiaryApp\Models\Diary\DiaryRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class infrastructureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DiaryRepositoryInterface::class, InMemoryDiaryRepository::class);
        $this->app->singleton(DiaryQueryServiceInterface::class, InMemoryDiaryQueryService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
