<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Config;
use Illuminate\Database\QueryException;

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
		try{
			config(Config::make());
		}catch(QueryException $e){
			
		}
    }
}
