<?php

namespace ThachVd\LaravelSiteControllerApi;

use Illuminate\Support\ServiceProvider;
use ThachVd\LaravelSiteControllerApi\Console\Commands\EmptyRoomFromTlLincoln;
use ThachVd\LaravelSiteControllerApi\Console\Commands\MasterHotelFromTlLincoln;
use ThachVd\LaravelSiteControllerApi\Console\Commands\MasterPlanDiffFromTlLincoln;
use ThachVd\LaravelSiteControllerApi\Console\Commands\MasterPlanFromTlLincoln;
use ThachVd\LaravelSiteControllerApi\Console\Commands\MasterRoomTypeDiffFromTlLincoln;
use ThachVd\LaravelSiteControllerApi\Console\Commands\MasterRoomTypeFromTlLincoln;
use ThachVd\LaravelSiteControllerApi\Console\Commands\PlanPriceFromTlLincoln;
use ThachVd\LaravelSiteControllerApi\Http\Middleware\ScApiAuth;

class SiteControllerApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->mergeConfigFrom(
            __DIR__ . '/configs/sc.php', 'sc'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/configs/sc_filesystems.php', 'sc_filesystems'
        );

        if (file_exists(config_path('sc_filesystems.php'))) {
            $this->mergeConfigFrom(config_path('sc_filesystems.php'), 'filesystems.disks');
        }

        $this->commands([
            MasterHotelFromTlLincoln::class,
            MasterRoomTypeFromTlLincoln::class,
            MasterRoomTypeDiffFromTlLincoln::class,
            MasterPlanFromTlLincoln::class,
            MasterPlanDiffFromTlLincoln::class,
            EmptyRoomFromTlLincoln::class,
            PlanPriceFromTlLincoln::class,
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->loadRoutesFrom(__DIR__ . '/routes/sc.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // publish migration
        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations'),
        ], 'sc-api-migrations');

        // publish config
        $this->publishes([
            __DIR__ . '/configs/sc.php' => config_path('sc.php'),
        ], 'sc-api-configs');

        // publish config filesystems
        $this->publishes([
            __DIR__ . '/configs/sc_filesystems.php' => config_path('sc_filesystems.php'),
        ], 'sc-api-configs');

        // public commands
        $this->publishes([
            __DIR__ . '/Console/Commands/' => app_path('Console/Commands'),
        ], 'sc-api-commands');

        // public file xsd
        $this->publishes([
            __DIR__ . '/helper/xsd/' => app_path('helper/xsd'),
        ], 'sc-api-commands');

        $this->app['router']->aliasMiddleware('api.sc.auth', ScApiAuth::class);

        //// publish model
        //$publishedModelPaths = [
        //    __DIR__.'/Models/ScApiLog.php' => app_path('Models/ScApiLog.php'),
        //    __DIR__.'/Models/ScTlLincolnSoapApiLog.php' => app_path('Models/ScTlLincolnSoapApiLog.php'),
        //];
        //foreach ($publishedModelPaths as $packageModelPath => $publishedModelsPath) {
        //    if (!file_exists($publishedModelsPath)) {
        //        $this->publishes([
        //            $packageModelPath => $publishedModelsPath,
        //        ], 'sc-api-models');
        //    }
        //}
        //
        //// publish routes
        //$publishedRoutesPath = base_path('routes/sc.php');
        //if (!file_exists($publishedRoutesPath)) {
        //    $this->publishes([
        //        __DIR__ . '/routes/sc.php' => base_path('routes/sc.php'),
        //    ], 'sc-api-routes');
        //}
        //
        //// publish controllers
        //$publishedControllersPath = app_path('Http/Controllers/Sc/TlLincolnController.php');
        //if (!file_exists($publishedControllersPath)) {
        //    $this->publishes([
        //        __DIR__ . '/Controllers/Sc' => app_path('Http/Controllers/Sc'),
        //    ], 'sc-api-controllers');
        //}
        //
        //// publish services
        //$publishedServicesPath = app_path('Services/Sc');
        //if (!file_exists($publishedServicesPath)) {
        //    $this->publishes([
        //        __DIR__ . '/Services/Sc' => app_path('Services/Sc'),
        //    ], 'sc-api-services');
        //}

        // load routes
        //if (file_exists($publishedRoutesPath)) {
        //    echo "load routes from $publishedRoutesPath\n";
        //    $this->loadRoutesFrom($publishedRoutesPath);
        //}
        //
        //$this->commands([
        //    ScApiGenerateModels::class,
        //]);
    }
}
