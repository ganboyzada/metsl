<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/', function () {
        return view('metsl.pages.projects.project'); // The view file for the company detail page
    })->name('home');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::view('/projects', 'metsl.pages.projects.projects')->name('projects');

    Route::get('/project/{id}', function ($id) {
        return view('metsl.pages.projects.project'); // The view file for the company detail page
    })->name('projects.find');

    Route::view('/project/correspondence', 'metsl.pages.correspondence.index')->name('projects.correspondence');
    Route::view('/project/correspondence/create', 'metsl.pages.correspondence.create')->name('projects.correspondence.create');
    Route::view('/project/correspondence/view', 'metsl.pages.correspondence.view')->name('projects.correspondence.view');

    Route::view('/project/documents', 'metsl.pages.documents.index')->name('projects.documents');
    Route::view('/project/punch-list/create', 'metsl.pages.punch-list.create')->name('projects.punch-list.create');
    Route::view('/project/meetings/create', 'metsl.pages.meeting-minutes.create')->name('projects.meetings.create');
    Route::view('/project/meetings/view', 'metsl.pages.meeting-minutes.view')->name('projects.meetings.view');

    Route::view('/create-project', 'metsl.pages.projects.wizard.project-wizard')->name('projects.create');
});
