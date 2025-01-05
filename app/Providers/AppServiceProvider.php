<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        $all_projects = \App\Models\Project::get(['id' , 'name']);
        if(isset($all_projects[($all_projects->count() - 1)]->id)){
            $id= $all_projects[($all_projects->count() - 1)]->id;

        }
        
        \View::share('projects', $all_projects);
       // Model::preventLazyLoading();

        //
    }
}
