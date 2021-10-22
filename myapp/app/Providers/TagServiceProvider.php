<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TagRepository;
use App\Repositories\TagRepositoryInterface;

class TagServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            TagRepositoryInterface::class,
            TagRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
