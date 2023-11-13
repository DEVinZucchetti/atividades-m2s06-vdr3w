<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('pessoas')->group(function () {
    Route::get('', [PessoasController::class, 'index']);
    Route::post('', [PessoasController::class, 'store']);
    Route::put('{id}', [PessoasController::class, 'update']);
    Route::patch('{id}', [PessoasController::class, 'update']);
});
