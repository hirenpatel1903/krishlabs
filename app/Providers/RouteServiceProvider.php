<?php

namespace App\Providers;

use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\File;


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
    protected $api_namespace = 'App\Http\Controllers\Api';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
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

        //
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

        if(file_exists(storage_path('installed'))){
            $addons = Addon::all();
            if(!blank($addons)) {
                foreach($addons as $addon) {
                    if(isset(json_decode($addon->files)->web_route)) {
                        if(File::exists(__DIR__."/../../routes/{$addon->slug}.php")) {
                            Route::middleware('web')
                                ->namespace($this->namespace)
                                ->group(__DIR__."/../../routes/{$addon->slug}.php");
                        }
                    }
                }
            }
        }
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

        if(file_exists(storage_path('installed'))){
            $addons = Addon::all();
            if(!blank($addons)) {
                foreach($addons as $addon) {
                    if(isset(json_decode($addon->files)->api_route)) {
                        if(File::exists(__DIR__."/../../routes/{$addon->slug}.php")) {
                            Route::prefix('api')
                                ->middleware('api')
                                ->namespace($this->namespace)
                                ->group(__DIR__."/../../routes/{$addon->slug}-api.php");
                        }
                    }
                }
            }
        }
    }
}
