<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;


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

        Blade::directive('permitted', function ($expression) {
            return "<?php if(auth()->user()->is_admin || auth()->user()->allPermissions->contains('name', $expression)): ?>";
        });
    
        Blade::directive('endpermitted', function () {
            return "<?php endif; ?>";
        });
        
        \View::share('projects', $all_projects);
       // Model::preventLazyLoading();

        //
    }
}
