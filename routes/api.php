<?php

use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\SnagListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::group(['middleware' => ['cors']], function () {
    Route::post('loginUser',  [LoginController::class, "login"]);

});
Route::group(['middleware' => ['cors','auth:sanctum']], function () {
    Route::get('profile',  [LoginController::class, "profile"]);
    Route::post('logout',  [LoginController::class, "logout"]);

    Route::get('my-projects',  [ProjectController::class, "myProjects"]);
    Route::get('project-detail/{id}',  [ProjectController::class, "projectDetail"]);
    Route::get('project-statics/{id}',  [ProjectController::class, "getStaticses"]);

    Route::get('check-permission',  [SnagListController::class, "checkPermission"]);
    Route::get('all-snag-list/{project_id}',  [SnagListController::class, "getSnagList"]);
    Route::get('snag-list/{snag_list_id}',  [SnagListController::class, "getSnagListDetail"]);

    Route::get('status-periority-docs-options/{project_id}',  [SnagListController::class, "statusPeriorityOptions"]);
    Route::post('add-reply',  [SnagListController::class, "storeReply"]);
    Route::post('update-status',  [SnagListController::class, "updateStatus"]);
    Route::get('get-participates/{id}',  [SnagListController::class, "getParticipates"]);
    Route::post('store-snag-list',  [SnagListController::class, "store"]);
    Route::delete('delete-snag-list/{id}',  [SnagListController::class, "destroy"]);

    Route::get('get-drawings/{project_id}',  [SnagListController::class, "getDrawings"]);
    Route::get('get-snags-drawing/{project_id}/{id}',  [SnagListController::class, "getSnagsDrawing"]);


});    

