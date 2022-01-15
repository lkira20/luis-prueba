<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\RolesController;

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

Route::group([
    'middleware' => 'auth:api',
], function () {

    Route::apiResource('/user', UserController::class);
    Route::apiResource('/producto', ProductoController::class);

    Route::post('/asignarRole', [RolesController::class, 'asignarRole']);
    Route::post('/removerRole', [RolesController::class, 'removerRole']);
    Route::post('/asignarPermiso', [RolesController::class, 'asignarPermiso']);
    Route::post('/removerPermiso', [RolesController::class, 'removerPermiso']);
    Route::get('/checkRole', [RolesController::class, 'checkRole']);
    Route::get('/checkPermisos', [RolesController::class, 'checkPermisos']);
});

Route::group([
    'middleware' => 'api',

], function ($router) {

    Route::post('login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [\App\Http\Controllers\Api\V1\AuthController::class, 'refresh'])->name('refresh');
    Route::post('me', [\App\Http\Controllers\Api\V1\AuthController::class, 'me'])->name('me');
});