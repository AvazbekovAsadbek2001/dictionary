<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::view('/','welcome');

Route::get('/menu', [IndexController::class, 'menus'])->name('menus');
Route::get('/menu/{id}/sections',[IndexController::class, 'sections'])->name('sections');
Route::get('/menu/{menuId}/sections/{id}',[IndexController::class, 'types'])->name('types');
Route::get('/menu/{menuId}/sections/{id}/{type}',[IndexController::class, 'condition'])->name('condition');

Route::get('back/word', [IndexController::class, 'getword'])->name('getword');
Route::post('back/check', [IndexController::class, 'checkword'])->name('checkword');
