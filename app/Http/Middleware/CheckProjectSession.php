<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckProjectSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('projectID') && Session::has('projectName')){
            return $next($request);
        }else{ 
            
           // $project = Project::latest()->first();

              if(checkIfUserHasThisPermission(Session::get('projectID') ,'view_all_projects')){
                $project = \App\Models\Project::latest()->first();
            }else{
                $project =\App\Models\Project::whereHas('stakholders', function ($query) {
                $query->where(function ($q) {
                    $q->where('user_id', auth()->user()->id);
                });
                })->latest()->first();
            }


            if($project){
                session(['projectID' => $project->id]);
                session(['projectName' => $project->name]);
            }
        }
        return $next($request);
    }
}
