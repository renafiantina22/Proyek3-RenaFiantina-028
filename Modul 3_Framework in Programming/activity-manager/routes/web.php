<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/activities/trash', [ActivityController::class, 'trash'])
    ->name('activities.trash');

Route::patch('/activities/{id}/restore', [ActivityController::class, 'restore'])
    ->name('activities.restore');
    
Route::resource('activities', ActivityController::class);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
    ->name('categories.destroy');
