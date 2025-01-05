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
            
            $project = Project::latest()->first();
            if($project){
                session(['projectID' => $project->id]);
                session(['projectName' => $project->name]);
            }
        }
        return $next($request);
    }
}
