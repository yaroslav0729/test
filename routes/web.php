<?php

use App\Http\Controllers\Admin\MenuItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\CampaignsController;
use App\Http\Controllers\Admin\CampaignPricesController;
use App\Http\Controllers\Admin\CampaignCategoryController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DonationController;

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

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/sitemap.xml', [SitemapController::class, 'sitemap']);

Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:' . User::ROLE_ADMIN ]], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.index');

        Route::resource('pages', AdminPageController::class, ['as' => 'admin']);
        Route::resource('category', CategoryController::class, ['as' => 'admin']);
        Route::resource('subscription', SubscriptionController::class, ['as' => 'admin']);
        Route::resource('campaigns', CampaignsController::class, ['as' => 'admin']);
        Route::resource('campaign_categories', CampaignCategoryController::class, ['as' => 'admin']);

        Route::resource('donations', DonationController::class, ['as' => 'admin'])->only([
            'index', 'show'
        ]);

        Route::get('/preview_version/{id}', [AdminPageController::class, 'preview'])->name('admin.pages.preview');
        Route::get('/post_history/{id}', [AdminPageController::class, 'history'])->name('admin.pages.history');
        Route::post('/restore_post/{id}', [AdminPageController::class, 'restore'])->name('admin.pages.restore');
        Route::post('/save_status/{id}', [AdminPageController::class, 'saveStatus'])->name('admin.pages.save_status');

        Route::prefix('menu')->group(function (){
            Route::get('/{menuSlug}', [MenuItemController::class, 'index'])->name('admin.menu_items.index');
            Route::post('/{menuSlug}', [MenuItemController::class, 'store'])->name('admin.menu_items.store');
            Route::match(['get', 'post'], '/{menuSlug}/create', [MenuItemController::class, 'create'])->name('admin.menu_items.create');
            Route::match(['get', 'post'],'/{menuSlug}/{id}', [MenuItemController::class, 'edit'])->name('admin.menu_items.edit');
            Route::put('/{menuSlug}/{id}', [MenuItemController::class, 'update'])->name('admin.menu_items.update');
            Route::delete('/{menuSlug}/{id}', [MenuItemController::class, 'destroy'])->name('admin.menu_items.destroy');
        });

        Route::prefix('users')->group(function () {
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::post('update/{id}', [UserController::class, 'update'])->name('admin.user.update');
            Route::delete('delete/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
        });

        Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');

        Route::get('/get_template_form/{templateId}', [AdminPageController::class, 'getTemplateForm'])->name('admin.get_template_form');

        Route::post('media/upload_mce', [MediaController::class, 'upload']);

        // MediaManager
        ctf0\MediaManager\MediaRoutes::routes();
    });
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
//Route::get('/test', [Controller::class, 'test']);
Route::get('/{slug}', [PageController::class, 'showFromSlug'])->where('slug', '.*');
