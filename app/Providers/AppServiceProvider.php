<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
use View;
use Auth;
use App\Http\Controllers\CommonController;

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

      View::composer('*', function($view) {
          $view->with('auth', Auth::user());
          $view->with('common', new CommonController());
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
