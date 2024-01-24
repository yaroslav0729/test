<?php

use App\Http\Controllers\Admin\BannerController;
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
use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalPayController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SocialController;
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
Route::get('/check-donation-cron', [PageController::class, 'CheckDonationPingCron']);
Route::get('/sitemap.xml', [SitemapController::class, 'sitemap']);
Route::get('search', [SearchController::class, 'index'])->name('search.index');

Route::group(['middleware' => ['auth:sanctum', 'verified', 'role:' . User::ROLE_ADMIN]], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.index');

        Route::resource('pages', AdminPageController::class, ['as' => 'admin']);
        Route::post('pages/duplicate/{page}', [AdminPageController::class, 'duplicate'])->name('admin.pages.duplicate');
        Route::resource('category', CategoryController::class, ['as' => 'admin']);
        Route::resource('subscription', SubscriptionController::class, ['as' => 'admin']);
        Route::resource('campaigns', CampaignsController::class, ['as' => 'admin']);
        Route::post('campaigns/duplicate/{campaign}', [CampaignsController::class, 'duplicate'])->name('admin.campaigns.duplicate');
        Route::resource('campaign_categories', CampaignCategoryController::class, ['as' => 'admin']);

        Route::get('donations/export', [DonationController::class, 'exportCsv'])->name('donations.export');
        Route::get('donations/export-pdf/{donation}', [DonationController::class, 'exportDonationPdf'])->name('admin.donations.export_pdf');
        Route::resource('donations', DonationController::class, ['as' => 'admin'])->only([
            'index', 'show', 'update',
        ]);

        Route::post('donations/resend/{donation}', [DonationController::class, 'resend'])->name('admin.donations.resend-mail');

        Route::post('donations/status/{donation}', [DonationController::class, 'saveStatus'])->name('admin.donations.save_status');
        Route::post('donations/cancel-subscription/{subscriptionId}', [DonationController::class, 'cancelSubscription'])->name('admin.donation.cancel-subscription');
        Route::get('scheduled-qurbani', [DonationController::class, 'scheduledSacrifice'])->name('admin.donations.scheduled-sacrifice');

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

        Route::get('/banners', [BannerController::class, 'createOrEdit'])->name('admin.banner.create_or_edit');
        Route::post('/banners/create', [BannerController::class, 'store'])->name('admin.banner.store');
        Route::put('/banners/edit/{id}', [BannerController::class, 'update'])->name('admin.banner.update');

        Route::resource('foodpack', \App\Http\Controllers\Admin\FoodPackController::class, ['as' => 'admin'])->except([
            'show',
        ]);

        Route::resource('foodpack-qurbanies', \App\Http\Controllers\Admin\FoodPackQurbaniController::class, ['as' => 'admin'])->except([
            'show',
        ]);

        Route::resource('black-list', \App\Http\Controllers\Admin\BlackListController::class, ['as' => 'admin'])->except([
            'show', 'edit', 'update',
        ]);

        Route::post('foodpack/settings', [\App\Http\Controllers\Admin\FoodPackController::class, 'updateSettings'])->name('admin.foodpack.settings');

        Route::resource('foodpack-pages', \App\Http\Controllers\Admin\FoodPackPagesController::class, ['as' => 'admin'])->except([
            'show', 'edit', 'update',
        ]);

        Route::resource('foodpack-qurbanies-pages', \App\Http\Controllers\Admin\FoodPacksQurbaniesPagesController::class, ['as' => 'admin'])->except([
            'show', 'edit', 'update',
        ]);

        // MediaManager
        ctf0\MediaManager\MediaRoutes::routes();
        Route::post('media/upload', [\App\Http\Controllers\Admin\MediaController::class, 'upload'], ['as' => 'admin'])->name('media.upload');

//        Route::prefix('laravel-filemanager')->group(function () {
//            \UniSharp\LaravelFilemanager\Lfm::routes();
//
//        });
    });
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/donations', [UserController::class, 'donations'])->name('user.donations');
        Route::get('/ramadan/unsubscribe', [\App\Http\Controllers\RamadanController::class, 'unsubscribe'])->name('user.ramadan.unsubscribe');
        Route::post('/cancel-subscription/{subscriptionId}', [UserController::class, 'cancelSubscription'])->name('user.cancel-subscription');
    });
});

Route::prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/payment', [CartController::class, 'paymentForm'])->name('cart.payment');
    Route::post('/payment', [CartController::class, 'order'])->name('cart.order');
    Route::post('/refresh_quantity', [CartController::class, 'refreshQuantity'])->name('cart.quantity');
    Route::post('/check-account', [CartController::class, 'checkAccount'])->name('cart.check_account');
    Route::post('/get-cities', [CartController::class, 'getallcities'])->name('get-cities');
    Route::post('/upsell', [CartController::class, 'upsell'])->name('cart.upsell');
});

Route::prefix('paypal')->group(function () {
    Route::get('/payment_success', [PaymentController::class, 'paypalPaymentSuccess'])->name('paypal.payment.success');
    Route::get('/payment_cancel', [PaymentController::class, 'paypalPaymentCancel'])->name('paypal.payment.cancel');
});

Route::prefix('stripe')->group(function () {
    Route::post('/payment_success', [PaymentController::class, 'stripePaymentSuccess'])->name('stripe.payment.success');
    Route::get('/payment_cancel', [PaymentController::class, 'stripePaymentCancel'])->name('stripe.payment.cancel');
    Route::get('/ramadan', [App\Http\Controllers\RamadanController::class, 'process'])->name('stripe.ramadan.process');
    Route::get('/portal', [App\Http\Controllers\RamadanController::class, 'portal'])->name('stripe.portal')->middleware('auth:sanctum');
});

Route::prefix('globalpay')->group(function () {
    Route::get('/get_pay_link', [GlobalPayController::class, 'getPayLink'])->name('globalpay.get_pay_link');
    Route::match(['get', 'post'], '/payment_result', [GlobalPayController::class, 'result'])->name('globalpay.result');
});

Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');

Route::get('auth/facebook', [SocialController::class, 'facebookRedirect'])->name('auth_facebook');
Route::get('auth/facebook/callback', [SocialController::class, 'loginWithFacebook']);

Route::prefix('foodpack')->group(function () {
    Route::get('price', [\App\Http\Controllers\FoodPackController::class, 'index']);
    Route::any('show', [\App\Http\Controllers\FoodPackPagesController::class, 'show']);
    Route::prefix('qurbani')->group(function () {
        Route::get('price', [\App\Http\Controllers\FoodPackQurbaniController::class, 'index']);
        Route::any('show', [\App\Http\Controllers\FoodPackQurbaniPagesController::class, 'show']);
    });
});

Route::resource('nights-of-mercy', \App\Http\Controllers\RamadanController::class)
    ->except('show', 'edit', 'update', 'destroy', 'create');
Route::name('schedule-qurbani.')->group(function () {
    Route::get('/schedule-Qurbani', [\App\Http\Controllers\ScheduledSacrificeController::class, 'index'])->name('index');
    Route::post('/schedule-Qurbani', [\App\Http\Controllers\ScheduledSacrificeController::class, 'schedule'])->name('schedule');
});

Route::get('/test', [Controller::class, 'test']);
Route::get('/{slug}', [PageController::class, 'showFromSlug'])->where('slug', '.*');
