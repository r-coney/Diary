<?php

namespace App\Providers\DiaryApp;

use Illuminate\Support\ServiceProvider;
use Domain\DiaryApp\Models\Diary\DiaryRepositoryInterface;
use Domain\DiaryApp\Models\Category\CategoryRepositoryInterface;
use App\DiaryApp\UseCase\Diary\QueryServiceInterface as DiaryQueryServiceInterface;
use App\DiaryApp\Infrastructure\InMemory\Queries\DiaryQueryService as InMemoryDiaryQueryService;
use App\DiaryApp\Infrastructure\InMemory\Repositories\DiaryRepository as InMemoryDiaryRepository;
use App\DiaryApp\Infrastructure\InMemory\Repositories\CategoryRepository as InMemoryCategoryRepository;

class infrastructureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DiaryRepositoryInterface::class, InMemoryDiaryRepository::class);
        $this->app->singleton(DiaryQueryServiceInterface::class, InMemoryDiaryQueryService::class);
        $this->app->singleton(CategoryRepositoryInterface::class, InMemoryCategoryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
