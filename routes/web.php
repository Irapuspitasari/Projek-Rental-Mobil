<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', [CarController::class, 'index']);
Route::get('/car', [CarController::class, 'car']);

Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'Admin') {
        return view('dashboard');
    }
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::resource('brands', BrandController::class);
Route::resource('types', TypeController::class);
Route::resource('items', ItemController::class);
Route::get('/items/{slug}', [ItemController::class, 'show'])->name('items.show');
Route::post('/items/{item}/reviews', [ReviewController::class, 'store'])
    ->name('items.reviews.store')
    ->middleware('auth');

Route::put('/reviews/{review}', [ReviewController::class, 'update'])
    ->name('reviews.update')
    ->middleware('auth');

Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
    ->name('reviews.destroy')
    ->middleware('auth');

Route::resource('users', UserController::class);
