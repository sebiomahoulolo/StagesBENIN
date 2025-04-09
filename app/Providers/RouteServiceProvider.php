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
     * La route vers votre "home" pour l'application.
     * Généralement utilisée par le middleware d'authentification lors de la redirection.
     * COMMENTÉE car la redirection est gérée par rôle dans AuthenticatedSessionController.
     * Vous pouvez la laisser comme fallback si nécessaire.
     *
     * @var string
     */
    // public const HOME = '/dashboard'; // Route générique Breeze

    // Définir les chemins vers les dashboards spécifiques
     public const ADMIN_HOME = '/admin/dashboard';
     public const ETUDIANT_HOME = '/etudiant/dashboard';
     public const RECRUTEUR_HOME = '/recruteur/dashboard';


    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

         RateLimiter::for('login', function (Request $request) {
             return Limit::perMinute(5)->by($request->input('email') . '|' . $request->ip());
         });
    }

     /**
      * Define your route model bindings, pattern filters, and other route configuration.
      */
     public function boot(): void
     {
         $this->configureRateLimiting();

         $this->routes(function () {
             Route::middleware('api')
                 ->prefix('api')
                 ->group(base_path('routes/api.php'));

             Route::middleware('web')
                 ->group(base_path('routes/web.php'));
         });
     }
}