<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Orden;
use App\Models\Producto;
use App\Policies\UserPolicy;
use App\Policies\CategoriaPolicy;
use App\Policies\OrdenPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\VentaPolicy;

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
        // Registrar las políticas
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Categoria::class, CategoriaPolicy::class);
        Gate::policy(Producto::class, ProductoPolicy::class);
        Gate::policy(Venta::class, VentaPolicy::class);
    }
}