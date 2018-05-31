<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer("inc.sidebar", function ($view) {
            $view->with("groups", auth()->user()->groups()->orderBy("name", "asc")->get());
        });

        view()->composer("contacts.form", function ($view) {
            $view->with("formGroups", auth()->user()->groups()->orderBy("name", "asc")->pluck("name", "id"));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
