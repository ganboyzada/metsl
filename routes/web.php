<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::view('/', 'metsl.pages.dashboard')->name('home');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    

    Route::view('/companies', 'metsl.pages.companies')->name('companies');

    Route::get('/companies/{id}', function ($id) {
        return view('metsl.pages.company-detail'); // The view file for the company detail page
    })->name('company.detail');

    Route::view('/project/{id}', 'metsl.pages.project')->name('project');
});
