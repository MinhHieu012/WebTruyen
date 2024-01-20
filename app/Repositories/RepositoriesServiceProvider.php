<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->singleton(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class
        );
        
        $this->app->singleton(
            \App\Repositories\Role\RoleRepositoryInterface::class,
            \App\Repositories\Role\RoleRepository::class
        );
        
        $this->app->singleton(
            \App\Repositories\Permission\PermissionRepositoryInterface::class,
            \App\Repositories\Permission\PermissionRepository::class
        );
        
        
        $this->app->singleton(
            \App\Repositories\Category\CategoryRepositoryInterface::class,
            \App\Repositories\Category\CategoryRepository::class
        );
        
        $this->app->singleton(
            \App\Repositories\Author\AuthorRepositoryInterface::class,
            \App\Repositories\Author\AuthorRepository::class
        );
        
        $this->app->singleton(
            \App\Repositories\Chapter\ChapterRepositoryInterface::class,
            \App\Repositories\Chapter\ChapterRepository::class
        );
        
        $this->app->singleton(
            \App\Repositories\Story\StoryRepositoryInterface::class,
            \App\Repositories\Story\StoryRepository::class
        );
        
        $this->app->singleton(
            \App\Repositories\Rating\RatingRepositoryInterface::class,
            \App\Repositories\Rating\RatingRepository::class
        );
        
        $this->app->singleton(
            \App\Repositories\Star\StarRepositoryInterface::class,
            \App\Repositories\Star\StarRepository::class
        );
        //#replace#
    }
}
