<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DynamicFormController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/list-form');
});

Route::get('/list-form', [DynamicFormController::class, 'listForm'])->name('list-form');
Route::get('/form/{id}', [DynamicFormController::class, 'form'])->name('form');
Route::get('/dynamic-form', [DynamicFormController::class, 'dynamicForm'])->name('dynamic-form');
Route::get('/data-base/{id}/{name}', [DynamicFormController::class, 'dbTable'])->name('data-base');
