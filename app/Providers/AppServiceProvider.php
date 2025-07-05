<?php

namespace App\Providers;

use App\Models\PointSale;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;
use Laravel\Passport\Passport;
use Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Passport::routes();

        // get pointsale where date equals today
        $point_sale = PointSale::whereDate('created_at', now())->first();

        // return data view
        view()->composer('*', function ($view) use ($point_sale) {
            // pointsale
            $view->with('point_sale', $point_sale);
        });

        /*ADD THIS LINES*/
        $this->commands([
            InstallCommand::class,
            ClientCommand::class,
            KeysCommand::class,
        ]);

    }
}
