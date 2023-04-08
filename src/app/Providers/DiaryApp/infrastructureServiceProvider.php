<?php

namespace App\Providers\DiaryApp;

use App\DiaryApp\Infrastructure\InMemory\DiaryRepository as InMemoryDiaryRepository;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
