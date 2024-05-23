<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\StepFormController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('home');
//});

Route::get('/step-form/{step?}', [StepFormController::class, 'index'])->name('step-form');
