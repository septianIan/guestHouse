<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapReservationRoutes();

        $this->mapReceptionRoutes();

        $this->mapCashierRoutes();

        $this->mapAdminRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapReservationRoutes()
    {
        Route::middleware('web', 'auth', 'role:frontOffice')
            ->namespace($this->namespace . '\Reservation')
            ->prefix('reservation')
            ->name('reservation.')
            ->group(base_path('routes/reservation.php'));
    }

    protected function mapReceptionRoutes()
    {
        Route::middleware('web', 'auth', 'role:frontOffice')
            ->namespace($this->namespace . '\Reception')
            ->prefix('reception')
            ->name('reception.')
            ->group(base_path('routes/reception.php'));
    }

    protected function mapCashierRoutes()
    {
        Route::middleware('web', 'auth', 'role:frontOffice')
            ->namespace($this->namespace . '\Cashier')
            ->prefix('cashier')
            ->name('cashier.')
            ->group(base_path('routes/cashier.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('web', 'auth', 'role:admin')
            ->namespace($this->namespace .'\Admin')
            ->prefix('admin')
            ->name('admin.')
            ->group(\base_path('routes/admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
