<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\ProjectController;




Route::group(['middleware' => ['cors']], function () {
    Route::post('loginUser',  [LoginController::class, "login"]);

});
Route::group(['middleware' => ['cors','auth:sanctum']], function () {
    Route::get('profile',  [LoginController::class, "profile"]);
    Route::post('logout',  [LoginController::class, "logout"]);

    Route::get('my-projects',  [ProjectController::class, "myProjects"]);
    Route::get('project-detail/{id}',  [ProjectController::class, "projectDetail"]);
    Route::get('project-statics/{id}',  [ProjectController::class, "getStaticses"]);

});    

