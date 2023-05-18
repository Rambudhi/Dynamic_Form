<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DynamicFormController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'api'], function () {
    Route::post('/save-form', [DynamicFormController::class, 'saveForm'])->name('api-save-form');
    Route::post('/delete-form', [DynamicFormController::class, 'deleteForm'])->name('api-delete-form');

    Route::post('/save', [DynamicFormController::class, 'save'])->name('api-save');
});
