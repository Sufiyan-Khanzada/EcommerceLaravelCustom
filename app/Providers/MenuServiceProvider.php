<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\MenuService;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MenuService::class, function ($app) {
            return new MenuService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(MenuService $menuService): void
    {
        View::composer('*', function ($view) use ($menuService) {
            $view->with('menuItems', $menuService->getMenuItems());
        });

        View::composer('*', function ($view) use ($menuService) {
            $view->with('getNews', $menuService->getNews());
        });


        View::composer('*', function ($view) use ($menuService) {
            $view->with('subMenuItems', $menuService->getSubMenuItems());
        });

        


    }
}
