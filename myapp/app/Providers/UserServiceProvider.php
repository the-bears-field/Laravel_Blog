<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepository;
use App\Repositories\TagRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\UserService;
use App\Services\UserServiceInterface;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(UserServiceInterface::class, function ($app): UserService {
                return new UserService(
                    $app->make(PostRepositoryInterface::class),
                    $app->make(TagRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class)
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
