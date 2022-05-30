<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\WebhookController;

Route::get('/', [InvitationController::class, 'show'])->name('invitation.show');

Route::post('/invitation', [InvitationController::class, 'enter'])->name('invitation.enter');

Route::get('/list/{code}', [InvitationController::class, 'enterWithCode'])->name('invitation.share');

// User
Route::group([
    'prefix' => 'user',
    'as' => 'user.',
    'namespace' => 'User'
], function () {
    Route::get('/', [ArticleController::class, 'show'])->name('articles');
    Route::get('/cart', [ArticleController::class, 'showCart'])->name('cart.show');
    Route::post('/cart-add', [ArticleController::class, 'store'])->name('cart.store');
    Route::post('/cart-remove', [ArticleController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/add/{id}', [ArticleController::class, 'addItem'])->name('cart.add.item');
    Route::post('/cart/remove/{id}', [ArticleController::class, 'removeItem'])->name('cart.remove.item');
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/order/success', [CheckoutController::class, 'success'])->name('order.success');
    Route::post('/webhooks/mollie', [WebhookController::class, 'handle'])->name('webhooks.mollie');
    Route::post('/send-email', [CheckoutController::class, 'sendEmail'])->name('send.email');
});

// Parent
Route::group([
    'prefix' => 'parent',
    'as' => 'parent.',
    'namespace' => 'Parent',
    'middleware' => ['auth']
], function () {
    Route::get('/wishlists', [ParentController::class, 'showWishlists'])->name('wishlists.show');
    Route::get('/wishlist/create', [ParentController::class, 'createWishlist'])->name('wishlist.create');
    Route::post('/wishlist/create', [ParentController::class, 'storeWishlist'])->name('wishlist.store');

    Route::post('/wishlist/destroy/{id}', [ParentController::class, 'destroyWishlist'])->name('wishlist.destroy');
    Route::get('/wishlist/{id}', [ParentController::class, 'showWishlist'])->name('wishlist.show');
    Route::get('/wishlist/{id}/add/articles', [ParentController::class, 'showArticles'])->name('wishlist.add.articles');

    Route::post('/wishlist/add/{id}', [ParentController::class, 'addItem'])->name('wishlist.add.item');
    Route::post('/wishlist/remove/{id}', [ParentController::class, 'removeItem'])->name('wishlist.remove.item');

    Route::get('/wishlist/{id}/share', [ParentController::class, 'copyToClipboard'])->name('wishlist.share');
    // export
    Route::get('/wishlist/{id}/export', [ParentController::class, 'downloadPDF'])->name('wishlist.export');

    Route::get('/orders', [ParentController::class, 'showOrders'])->name('orders.show');
    Route::get('/order/{id}', [ParentController::class, 'showOrder'])->name('order.show');
});

// Admin
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => ['auth', 'admin']
], function () {
    Route::get('/scraper', [Admin\ScraperController::class, 'show'])->name('scraper');
    Route::post('scraper/categories', [Admin\ScraperController::class, 'scrapeCategories'])->middleware(['auth'])->name('scraper.categories');
    Route::post('scraper/articles', [Admin\ScraperController::class, 'scrapeArticles'])->middleware(['auth'])->name('scraper.articles');
    Route::get('/scraped-articles', [Admin\ScraperController::class, 'showArticles'])->name('scraped.articles');
});

// Admin
// Route::group([
//     'prefix' => 'amdin',
//     'as' => 'amdin.',
//     'namespace' => 'Admin',
//     'middleware' => ['auth', 'amdin']
// ], function () {
//     Route::get('/scraper', [Admin\ScraperController::class, 'show'])->name('scraper');

//     Route::post('scraper/categories', [Admin\ScraperController::class, 'scrapeCategories'])->middleware(['auth'])->name('scraper.categories');

//     Route::post('scraper/articles', [Admin\ScraperController::class, 'scrapeArticles'])->middleware(['auth'])->name('scraper.articles');

//     Route::get('/scraped-articles', [Admin\ScraperController::class, 'showArticles'])->name('scraped.articles');
// });

// Route::get('/scraper', [Admin\ScraperController::class, 'show'])->middleware(['auth'])->name('scraper');

// Route::post('scraper/categories', [Admin\ScraperController::class, 'scrapeCategories'])->middleware(['auth'])->name('scraper.categories');

// Route::post('scraper/articles', [Admin\ScraperController::class, 'scrapeArticles'])->middleware(['auth'])->name('scraper.articles');

// Route::get('/scraped-articles', [Admin\ScraperController::class, 'showArticles'])->name('scraped.articles');

// Route::get('/articles', [ArticleController::class, 'show'])->name('articles');

// Route::get('/cart', [ArticleController::class, 'showCart'])->name('user.cart.show');

// Route::post('/cart-add', [ArticleController::class, 'store'])->name('user.cart.store');

// Route::post('/cart-remove', [ArticleController::class, 'remove'])->name('user.cart.remove');

// Route::post('/cart/add/{id}', [ArticleController::class, 'addItem'])->name('user.cart.add.item');

// Route::post('/cart/remove/{id}', [ArticleController::class, 'removeItem'])->name('user.cart.remove.item');

// Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

// Route::get('/order/success', [CheckoutController::class, 'success'])->name('order.success');

// Route::post('/webhooks/mollie', [WebhookController::class, 'handle'])->name('webhooks.mollie');

require __DIR__.'/auth.php';