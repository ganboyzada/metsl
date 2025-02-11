<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Permission;




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
            $permission = Permission::where('name' , $expression)->first();
            $permission_id = (isset($permission->id)) ? $permission->id :0;
            $chk_flag = false;
       
            if(auth()->user() != NULL){
                if(auth()->user()->allPermissions->count() > 0){
                    foreach(auth()->user()->allPermissions as $permission){
                        if($permission->pivot->project_id == Session::get('projectID') && $permission->pivot->permission_id == $permission_id){
                            $chk_flag = true;
                            break;
                        }
                    }
                }
            }

                return "<?php if(auth()->user()->is_admin || $chk_flag ): ?>";
            });
    
        Blade::directive('endpermitted', function () {
            return "<?php endif; ?>";
        });
        
        \View::share('projects', $all_projects);
       // Model::preventLazyLoading();

        //
    }
}
