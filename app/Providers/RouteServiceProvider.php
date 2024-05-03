<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware(['api', 'header.source.check'])
                ->prefix('api/' . config('common.route_prefix.v1'))
                ->group(base_path('routes/api.php'));

            $this->v1_routes();

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    public function v1_routes()
    {
        $version = config('common.route_prefix.v1');

        Route::group([
            'prefix' => 'api/' . $version,
            'middleware' => ['api', 'header.source.check'],
            'namespace' => 'App\Http\Controllers\\' . strtoupper($version)
        ], function () use ($version) {
            $basePath = base_path('routes/' . $version);

            Route::prefix('')
                ->group($basePath . '/common.php');

            Route::namespace('Auth')
                ->group($basePath . '/auth.php');
        });
    }
}
