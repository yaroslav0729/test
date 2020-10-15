<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\UserController;

use App\Models\User;
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

Route::get('/', [PostController::class, 'index'])->name('index');
//Route::get('/test', [UserController::class, 'test']);

Route::group(['middleware' => ['role:' . User::ROLE_SUPER_ADMIN ]], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.index');
        
        Route::prefix('users')->group(function () {
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        });
    });

});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/{slug}', [PostController::class, 'showFromSlug']);