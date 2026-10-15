<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::view('/','welcome');

Route::get('/menu', [IndexController::class, 'menus'])->name('menus');
Route::get('/menu/{id}/sections',[IndexController::class, 'sections'])->name('sections');
Route::get('/menu/{menuId}/sections/{id}',[IndexController::class, 'types'])->name('types');
Route::get('/condition',[IndexController::class, 'condition'])->name('condition');

