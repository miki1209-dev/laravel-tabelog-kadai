<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WebController::class, 'index'])->name('top');

require __DIR__ . '/auth.php';
Route::middleware(['auth', 'verified'])->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::controller(UserController::class)->group(function () {
		Route::get('users/mypage', 'mypage')->name('mypage');
		Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
		Route::put('users/mypage', 'update')->name('mypage.update');
	});

	Route::controller(ShopController::class)->group(function () {
		Route::get('shops', 'index')->name('shops.index');
		Route::get('shops/{shop}', 'show')->name('shops.show');
	});

	Route::controller(FavoriteController::class)->group(function () {
		Route::post('shops/{shop}/favorite', 'store')->name('favorite.store');
		Route::delete('shops/{shop}/favorite', 'destroy')->name('favorite.destroy');
	});

	Route::controller(ReviewController::class)->group(function () {
		Route::post('/reviews', 'store')->name('reviews.store');
		Route::put('/reviews/{review}', 'update')->name('reviews.update');
		Route::delete('/reviews/{review}', 'destroy')->name('reviews.destroy');
	});
});

Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
