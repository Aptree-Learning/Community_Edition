<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZapierController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('zapier/me', [ZapierController::class, 'me']);
Route::post('zapier/subscribe', [ZapierController::class, 'subscribeHook']);
Route::delete('zapier/subscribe', [ZapierController::class, 'unsubscribeHook']);
Route::post('zapier/perfom', [ZapierController::class, 'performList']);
Route::post('zapier/actions', [ZapierController::class, 'actionList']);

