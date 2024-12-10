<?php

use App\Http\Controllers\CorrespondenceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentRevisionController;
use App\Http\Controllers\MeetingPlaningController;
use App\Http\Controllers\ProjectController;
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

    Route::get('/project/storeIdSession', action: [ProjectController::class, "storeIdSession"])->name('projects.store_id_session');

    Route::get('/project/{id}', function ($id) {
        return view('metsl.pages.projects.project'); // The view file for the company detail page
    })->name('projects.find');
    Route::get('/project/correspondence/view/{id}', [CorrespondenceController::class, "find"])->name('projects.correspondence.view');

    Route::view('/project/correspondence', 'metsl.pages.correspondence.index')->name('projects.correspondence');
    Route::get('/project/correspondence/create',  [CorrespondenceController::class, "create"])->name('projects.correspondence.create');
	Route::post('/project/correspondence/store',  [CorrespondenceController::class, "store"])->name('projects.correspondence.store');
    Route::get('/project/correspondence/all',  [CorrespondenceController::class, "ProjectCorrespondence"])->name('projects.correspondence.all');


    Route::get('/project/correspondence/users',  [CorrespondenceController::class, "getUsers"])->name('projects.correspondence.users');	

    Route::view('/project/documents', 'metsl.pages.documents.index')->name('projects.documents');
	Route::get('/project/documents/reviewers',  [DocumentController::class, "getreviewers"])->name('projects.documents.reviewers');	
	Route::post('/project/documents/store',  [DocumentController::class, "store"])->name('projects.documents.store');
    Route::get('/project/documents/all',  [DocumentController::class, "ProjectDocuments"])->name('projects.documents.all');
    
    Route::get('/project/documents/revisions/update_status',  [DocumentRevisionController::class, "update_status"])->name('projects.documents.revision.update_status');
	Route::post('/projects/documents/revision/comments/store',  [DocumentRevisionController::class, "store_comment"])->name('projects.documents.revision.comments.store');
	Route::post('/projects/documents/revision/store',  [DocumentRevisionController::class, "store"])->name('projects.documents.revision.store');
	Route::get('/project/documents/revisions/comments/{id}',  [DocumentRevisionController::class, "revisionComments"])->name('projects.documents.revisions.comments');

	Route::get('/project/documents/revisions/{id}',  [DocumentController::class, "ProjectDocumentsRevisions"])->name('projects.documents.revisions');



    Route::view('/project/punch-list/create', 'metsl.pages.punch-list.create')->name('projects.punch-list.create');
	
	Route::get('/project/meetings/all',  [MeetingPlaningController::class, "ProjectMeeetings"])->name('projects.meetings.all');
	Route::get('/project/meetings/create',  [MeetingPlaningController::class, "create"])->name(name: 'projects.meetings.create');	
    Route::get('/project/meetings/participates',  [MeetingPlaningController::class, "getParticipates"])->name('projects.meetings.participates');	
	Route::post('/project/meetings/store',  [MeetingPlaningController::class, "store"])->name(name: 'projects.meetings.store');	

    Route::view('/project/meetings/view/{id}', 'metsl.pages.meeting-minutes.meeting_minutes')->name('projects.meetings.view');

    Route::post('/project/store', action: [ProjectController::class, "store"])->name('projects.store');


    Route::get('/projects',action: [ProjectController::class, "allProjects"] )->name('projects');
    Route::get('/create-project',action: [ProjectController::class, "create"] )->name('projects.create');
    Route::post('/project/users/store', action: [ProjectController::class, "store_user"])->name('projects.users.store');});
