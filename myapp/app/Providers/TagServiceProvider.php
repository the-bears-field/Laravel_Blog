<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TagRepository;
use App\Repositories\TagRepositoryInterface;
use App\Services\TagService;
use App\Services\TagServiceInterface;

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

        $this->app->bind(TagServiceInterface::class, function ($app): TagService {
                return new TagService(
                    $app->make(TagRepositoryInterface::class)
                );
            }
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
