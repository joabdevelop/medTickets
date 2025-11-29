<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Services\MenuService;

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
        Paginator::useBootstrapFive();

        // 1. Registra o View Composer
        View::composer('layouts.app', function ($view) {
            // 'layouts.app' é um exemplo, ajuste para o seu layout

            // 2. Resolve o MenuService via injeção de dependência
            $menuService = app(MenuService::class);

            // 3. Obtém o array de menu filtrado
            $filteredMenuItems = $menuService->getFilteredMenuItems();

            // 4. Injeta a variável 'menuItems' na view
            $view->with('filteredMenuItems', $filteredMenuItems);
        });
    }
}
