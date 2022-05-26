<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\WebhookController;

Route::get('/', [InvitationController::class, 'show']);

Route::post('/invitation', [InvitationController::class, 'enter'])->name('invitation.enter');

// Only if user isAdmin (see app\Models\User.php)
Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::get('/admin', [Admin\AdminController::class, 'index']);
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/scraper', [Admin\ScraperController::class, 'show'])->middleware(['auth'])->name('scraper');

Route::post('scraper/categories', [Admin\ScraperController::class, 'scrapeCategories'])->middleware(['auth'])->name('scraper.categories');

Route::post('scraper/articles', [Admin\ScraperController::class, 'scrapeArticles'])->middleware(['auth'])->name('scraper.articles');

Route::get('/scraped-articles', [Admin\ScraperController::class, 'showArticles'])->name('scraped.articles');

Route::get('/articles', [ArticleController::class, 'show'])->name('articles');

Route::get('/cart', [ArticleController::class, 'showCart'])->name('cart.show');

Route::post('/cart-add', [ArticleController::class, 'store'])->name('cart.store');

Route::post('/cart-remove', [ArticleController::class, 'remove'])->name('cart.remove');

Route::post('/cart/add/{id}', [ArticleController::class, 'addItem'])->name('cart.add.item');

Route::post('/cart/remove/{id}', [ArticleController::class, 'removeItem'])->name('cart.remove.item');

Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

Route::get('/order/success', [CheckoutController::class, 'success'])->name('order.success');

Route::post('/webhooks/mollie', [WebhookController::class, 'handle'])->name('webhooks.mollie');

require __DIR__.'/auth.php';