<?php

namespace App\Providers\DiaryApp;

use Domain\DiaryApp\Models\Diary\Factory as DiaryFactory;
use Illuminate\Support\ServiceProvider;
use Domain\DiaryApp\Models\Diary\FactoryInterface as DiaryFactoryInterface;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DiaryFactoryInterface::class, DiaryFactory::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
