<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::addNamespace('admin', resource_path('admin'));
        View::addNamespace('personal', resource_path('personal'));
        View::addNamespace('web', resource_path('web'));
        View::addNamespace('auth', resource_path('auth'));

        Paginator::useBootstrap();

        View::composer('personal::blade.includes.sidebar', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();

                $totalCount = $user->notifications()
                    ->whereNull('read_at')
                    ->count();

                $user->notifications()
                    ->whereNull('read_at');

                $view->with([
                    'unreadCount' => $totalCount,
                ]);
            }
        });
    }
}
