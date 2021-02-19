<?php

use App\Http\Controllers\Admin\CampaignCategoryController;
use App\Http\Controllers\Admin\CampaignsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\EmailLogController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\GlobalPayController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
Route::get('search', [SearchController::class, 'index'])->name('search.index');

Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:' . User::ROLE_ADMIN]], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.index');

        Route::resource('pages', AdminPageController::class, ['as' => 'admin']);
        Route::resource('category', CategoryController::class, ['as' => 'admin']);
        Route::resource('subscription', SubscriptionController::class, ['as' => 'admin']);
        Route::resource('campaigns', CampaignsController::class, ['as' => 'admin']);
        Route::resource('campaign_categories', CampaignCategoryController::class, ['as' => 'admin']);

        Route::get('donations/export', [DonationController::class, 'exportCsv'])->name('donations.export');
        Route::resource('donations', DonationController::class, ['as' => 'admin'])->only([
            'index', 'show',
        ]);

        Route::resource('redirects', RedirectController::class, ['as' => 'admin']);

        Route::resource('email_logs', EmailLogController::class, ['as' => 'admin'])->only([
            'index', 'show', 'destroy',
        ]);

        Route::get('settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('admin.settings.update');

        Route::get('/email_logs/show_email/{email_log}', [EmailLogController::class, 'showEmail'])->name('admin.email_logs.show_email');
        Route::post('/email_logs/resend/{email_log}', [EmailLogController::class, 'resend'])->name('admin.email_logs.resend');

        Route::get('/preview_version/{id}', [AdminPageController::class, 'preview'])->name('admin.pages.preview');
        Route::get('/post_history/{id}', [AdminPageController::class, 'history'])->name('admin.pages.history');
        Route::post('/restore_post/{id}', [AdminPageController::class, 'restore'])->name('admin.pages.restore');
        Route::post('/save_status/{id}', [AdminPageController::class, 'saveStatus'])->name('admin.pages.save_status');

        Route::prefix('menu')
            ->where([
                'parent' => '\d+',
                'menuItem' => '\d+',
                'menuSlug' => implode('|', MenuItem::ALL_SLUG_MENU),
            ])
            ->group(function () {
                Route::get('/', [MenuItemController::class, 'index'])->name('admin.menu_items.index');

                Route::get('/{menuSlug}', [MenuItemController::class, 'show'])->name('admin.menu_items.show');
                Route::get('/{parent}', [MenuItemController::class, 'showSubmenu'])->name('admin.menu_items.show_submenu');

                Route::post('/{menuSlug}', [MenuItemController::class, 'store'])->name('admin.menu_items.store');
                Route::post('/{parent}', [MenuItemController::class, 'storeSubmenu'])->name('admin.menu_items.store_submenu');

                Route::get('/{parent}/create', [MenuItemController::class, 'createSubmenu'])->name('admin.menu_items.create_submenu');
                Route::get('/{menuSlug}/create', [MenuItemController::class, 'create'])->name('admin.menu_items.create');

                Route::get('/{menuItem}/edit', [MenuItemController::class, 'edit'])->name('admin.menu_items.edit');
                Route::put('/{menuItem}/edit', [MenuItemController::class, 'update'])->name('admin.menu_items.update');

                Route::get('/{menuItem}/move-up', [MenuItemController::class, 'moveUp'])->name('admin.menu_items.move_up');
                Route::get('/{menuItem}/move-down', [MenuItemController::class, 'moveDown'])->name('admin.menu_items.move_down');

                Route::delete('/{menuItem}', [MenuItemController::class, 'destroy'])->name('admin.menu_items.destroy');
            });

        Route::prefix('users')->group(function () {
            Route::get('show/{id}', [AdminUserController::class, 'show'])->name('admin.user.show');
            Route::get('edit/{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
            Route::post('update/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
            Route::delete('delete/{id}', [AdminUserController::class, 'delete'])->name('admin.user.delete');
        });

        Route::get('/get_template_form/{templateId}', [AdminPageController::class, 'getTemplateForm'])->name('admin.get_template_form');

        Route::post('media/upload_mce', [MediaController::class, 'upload']);

        // MediaManager
        ctf0\MediaManager\MediaRoutes::routes();
    });
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::prefix('user')->group(function () {
        Route::get('/donations', [UserController::class, 'donations'])->name('user.donations');
    });
});

Route::prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/payment', [CartController::class, 'paymentForm'])->name('cart.payment');
    Route::post('/payment', [CartController::class, 'order'])->name('cart.order');
    Route::post('/refresh_quantity', [CartController::class, 'refreshQuantity'])->name('cart.quantity');

});

Route::prefix('paypal')->group(function () {
    Route::get('/payment_success', [PaymentController::class, 'paypalPaymentSuccess'])->name('paypal.payment.success');
    Route::get('/payment_cancel', [PaymentController::class, 'paypalPaymentCancel'])->name('paypal.payment.cancel');
});

Route::prefix('globalpay')->group(function () {
    Route::get('/get_pay_link', [GlobalPayController::class, 'getPayLink'])->name('globalpay.get_pay_link');
    Route::match(['get', 'post'], '/payment_result', [GlobalPayController::class, 'result'])->name('globalpay.result');
});

Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');

Route::get('auth/facebook', [SocialController::class, 'facebookRedirect'])->name('auth_facebook');
Route::get('auth/facebook/callback', [SocialController::class, 'loginWithFacebook']);

//Route::get('/test', [Controller::class, 'test']);
Route::get('/{slug}', [PageController::class, 'showFromSlug'])->where('slug', '.*');
