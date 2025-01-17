<?php

use App\Http\Controllers\CorrespondenceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentRevisionController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MeetingPlaningController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PunchListController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'CheckProjectSession',
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
    
])->group(function () {


    Route::get('/', action: [ProjectController::class, "detail"])->name(name: 'home');



    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/roles',  [RoleController::class, "index"])->name('roles');
    Route::get('/roles/create',  [RoleController::class, "create"])->name('roles.create');
    Route::post('/roles/store',  [RoleController::class, "store"])->name('roles.store');

    Route::get('/roles/edit/{id}',  [RoleController::class, "edit"])->name('roles.edit');
    Route::delete('/roles/destroy/{id}',  [RoleController::class, "destroy"])->name('roles.destroy');
    Route::put('/roles/update/{id}',  [RoleController::class, "update"])->name('roles.update');


    Route::view('/roles/permissions', 'metsl.pages.permissions.index')->name('roles.permissions');
    Route::view('/roles/permissions/create', 'metsl.pages.permissions.create')->name('roles.permissions.create');

    Route::get('/project/storeIdSession', [ProjectController::class, "storeIdSession"])->name('projects.store_id_session');

    Route::get('/project/{id}', function ($id) {
        return view('metsl.pages.projects.project'); // The view file for the company detail page
    })->name('projects.find');
    Route::get('/project/correspondence/view/{id}', [CorrespondenceController::class, "find"])->name('projects.correspondence.view');

    Route::view('/project/correspondence', 'metsl.pages.correspondence.index')->name('projects.correspondence');
    Route::get('/project/correspondence/create',  [CorrespondenceController::class, "create"])->name('projects.correspondence.create');
	Route::post('/project/correspondence/store',  [CorrespondenceController::class, "store"])->name('projects.correspondence.store');
    Route::get('/project/correspondence/all',  [CorrespondenceController::class, "ProjectCorrespondence"])->name('projects.correspondence.all');


    Route::get('/project/correspondence/users',  [CorrespondenceController::class, "getUsers"])->name('projects.correspondence.users');	
    Route::get('/project/correspondence/edit/{id}', [CorrespondenceController::class, "edit"])->name('projects.correspondence.edit');

	Route::post('/project/correspondence/update',  [CorrespondenceController::class, "update"])->name(name: 'projects.correspondence.update');	
	Route::get('/project/correspondence/destroy/{id}',  [CorrespondenceController::class, "destroy"])->name(name: 'projects.correspondence.destroy');	
    Route::get('/project/correspondence/destroy-file/{id}',  [CorrespondenceController::class, "destroyFile"])->name(name: 'projects.correspondence.destroy-file');	
    
    Route::view('/project/documents', 'metsl.pages.documents.index')->name('projects.documents');
	Route::get('/project/documents/reviewers',  [DocumentController::class, "getreviewers"])->name('projects.documents.reviewers');	
	Route::post('/project/documents/store',  [DocumentController::class, "store"])->name('projects.documents.store');
    Route::get('/project/documents/all',  [DocumentController::class, "ProjectDocuments"])->name('projects.documents.all');
    
    Route::get('/project/documents/revisions/update_status',  [DocumentRevisionController::class, "update_status"])->name('projects.documents.revision.update_status');
	Route::post('/projects/documents/revision/comments/store',  [DocumentRevisionController::class, "store_comment"])->name('projects.documents.revision.comments.store');
	Route::post('/projects/documents/revision/store',  [DocumentRevisionController::class, "store"])->name('projects.documents.revision.store');
	Route::get('/project/documents/revisions/comments/{id}',  [DocumentRevisionController::class, "revisionComments"])->name('projects.documents.revisions.comments');
	Route::get('/project/documents/edit/{id}',  [DocumentController::class, "edit"])->name('projects.documents.edit');
	Route::post('/project/documents/update',  [DocumentController::class, "update"])->name('projects.documents.update');
	Route::get('/project/documents/revisions/{id}',  [DocumentController::class, "ProjectDocumentsRevisions"])->name('projects.documents.revisions');
	Route::get('/project/documents/delete/{id}',  [DocumentController::class, "delete"])->name('projects.documents.delete');
	Route::get('/project/documents/delete_file/{id}',  [DocumentController::class, "delete_file"])->name('projects.documents.delete_file');


	Route::get('/project/punch-list/all',  [PunchListController::class, "PunchList"])->name('projects.punch-list.all');
    Route::get('/project/punch-list/create', [PunchListController::class, "create"])->name('projects.punch-list.create');
    Route::get('/project/punch-list/participates',  [PunchListController::class, "getParticipates"])->name('projects.punch-list.participates');	
	Route::post('/project/punch-list/store',  [PunchListController::class, "store"])->name(name: 'projects.punch-list.store');	
    Route::get('/project/punch-list/edit/{id}', [PunchListController::class, "edit"])->name('projects.punch-list.edit');
    Route::get('/project/punch-list/allParticipates',  [PunchListController::class, "getAllParticipates"])->name('projects.punch-list.all_participates');	
    Route::get('/project/punch-list/allStatusPeriorityOption',  [PunchListController::class, "getStatusPeriorityOption"])->name('projects.punch-list.all_status_periority_option');	
	Route::post('/project/punch-list/update',  [PunchListController::class, "update"])->name(name: 'projects.punch-list.update');	
	Route::get('/project/punch-list/destroy/{id}',  [PunchListController::class, "destroy"])->name(name: 'projects.punch-list.destroy');	
    Route::get('/project/punch-list/destroy-file/{id}',  [PunchListController::class, "destroyFile"])->name(name: 'projects.punch-list.destroy-file');	


	Route::get('/project/meetings/all',  [MeetingPlaningController::class, "ProjectMeeetings"])->name('projects.meetings.all');
	Route::get('/project/meetings/create',  [MeetingPlaningController::class, "create"])->name(name: 'projects.meetings.create');	
    Route::get('/project/meetings/participates',  [MeetingPlaningController::class, "getParticipates"])->name('projects.meetings.participates');	
	Route::post('/project/meetings/store',  [MeetingPlaningController::class, "store"])->name(name: 'projects.meetings.store');	
    Route::view('/project/meetings/view/{id}', 'metsl.pages.meeting-minutes.meeting_minutes')->name('projects.meetings.view');
    Route::get('/project/meetings/edit/{id}', [MeetingPlaningController::class, "edit"])->name('projects.meetings.edit');

	Route::post('/project/meetings/update',  [MeetingPlaningController::class, "update"])->name(name: 'projects.meetings.update');	
	Route::get('/project/meetings/destroy/{id}',  [MeetingPlaningController::class, "destroy"])->name(name: 'projects.meetings.destroy');	
    Route::get('/project/meetings/destroy-file/{id}',  [MeetingPlaningController::class, "destroyFile"])->name(name: 'projects.meetings.destroy-file');	


    Route::get('/project/stakeholders/all',  [StakeholderController::class, "stakeholders"])->name('projects.stakeholders.all');
    Route::get('/project/stakeholders/edit/{id}',  [StakeholderController::class, "edit"])->name('projects.stakeholders.edit');
	Route::get('/project/stakeholders/destroy/{id}',  [StakeholderController::class, "destroy"])->name(name: 'projects.stakeholders.destroy');	
    Route::post('/project/stakeholders/update', action: [StakeholderController::class, "update"])->name('projects.stakeholders.update');

    Route::get('/project/groups/all',  [GroupController::class, "all"])->name(name: 'projects.groups.all');	
	Route::post('/project/groups/store',  [GroupController::class, "store"])->name(name: 'projects.groups.store');	
	Route::post('/project/groups/update',  [GroupController::class, "update"])->name(name: 'projects.groups.update');	
	Route::get('/project/groups/destroy/{id}',  [GroupController::class, "destroy"])->name(name: 'projects.groups.destroy');	
    

    Route::get('/project/tasks/all',  [TaskController::class, "all"])->name(name: 'projects.tasks.all');	
	Route::post('/project/tasks/store',  [TaskController::class, "store"])->name(name: 'projects.tasks.store');	
	Route::post('/project/tasks/update',  [TaskController::class, "update"])->name(name: 'projects.tasks.update');	
	Route::get('/project/tasks/destroy/{id}',  [TaskController::class, "destroy"])->name(name: 'projects.tasks.destroy');	


    Route::post('/project/store', action: [ProjectController::class, "store"])->name('projects.store');


    Route::get('/projects',action: [ProjectController::class, "allProjects"] )->name('projects');
    Route::get('/create-project',action: [ProjectController::class, "create"] )->name('projects.create');
    Route::post('/project/users/store', action: [ProjectController::class, "store_user"])->name('projects.users.store');});
    Route::get('/project/edit/{id}',action: [ProjectController::class, "edit"] )->name('projects.edit');
    Route::get('/project/destroy-file/{id}',  [ProjectController::class, "destroyFile"])->name('projects.destroy-file');	
    Route::post('/project/update',action: [ProjectController::class, "update"] )->name('projects.update');
    Route::get('/project/destroy/{id}',  [ProjectController::class, "destroy"])->name('projects.destroy');	
