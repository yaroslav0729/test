<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/get_proj_options/{id}', [ProjectController::class, 'getPopupOptions']);
Route::get('/get_articles/{category}/{page}', [ArticleController::class, 'getArticles']);
Route::post('/orders/express', [OrderController::class, 'placeExpressOrder']);
