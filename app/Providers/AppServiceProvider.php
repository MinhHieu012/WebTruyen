<?php

namespace App\Providers;

use App\Http\ViewComposers\ChapterComposer;
use App\Http\ViewComposers\HomeComposer;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\LayoutComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Breadcrumbs::for('home', function ($trail) {
            $trail->push('Tổng quan', route('admin.dashboard.index'));
        });

        Paginator::useBootstrap();

        if (in_array(config('app.env', 'local'), ['production', 'staging'])) {
            URL::forceScheme('https');
        }

        View::composer('Frontend.layouts.default', LayoutComposer::class);
        View::composer('Frontend.home', HomeComposer::class);
        View::composer('Frontend.category', LayoutComposer::class);
        View::composer('Frontend.follow_chapter_count', LayoutComposer::class);
        View::composer('Frontend.story', HomeComposer::class);
        View::composer('Frontend.chapter', ChapterComposer::class);
    }
}
