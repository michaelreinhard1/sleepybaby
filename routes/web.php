<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\InvitationController;

Route::get('/', [InvitationController::class, 'show']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/scraper', [Admin\ScraperController::class, 'show'])->middleware(['auth'])->name('scraper');

Route::post('scraper/categories', [Admin\ScraperController::class, 'scrapeCategories'])->middleware(['auth'])->name('scraper.categories');

Route::post('scraper/articles', [Admin\ScraperController::class, 'scrapeArticles'])->middleware(['auth'])->name('scraper.articles');

Route::get('/articles', [ArticleController::class, 'show'])->middleware(['auth'])->name('articles');

require __DIR__.'/auth.php';