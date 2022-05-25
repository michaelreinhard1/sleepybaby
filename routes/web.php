<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\InvitationController;

Route::get('/', [InvitationController::class, 'show']);

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

Route::get('/articles', [ArticleController::class, 'show'])->middleware(['auth'])->name('articles');

Route::get('/cart', [ArticleController::class, 'showCart'])->middleware(['auth'])->name('cart.show');

Route::post('/cart-add', [ArticleController::class, 'store'])->middleware(['auth'])->name('cart.store');

Route::post('/cart-remove', [ArticleController::class, 'remove'])->middleware(['auth'])->name('cart.remove');

Route::post('/cart/add/{id}', [ArticleController::class, 'addItem'])->middleware(['auth'])->name('cart.add.item');

Route::post('/cart/remove/{id}', [ArticleController::class, 'removeItem'])->middleware(['auth'])->name('cart.remove.item');

Route::get('/checkout', [ArticleController::class, 'checkout'])->middleware(['auth'])->name('checkout');

require __DIR__.'/auth.php';