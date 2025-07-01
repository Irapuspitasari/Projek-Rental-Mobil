<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookingController;
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

require __DIR__ . '/auth.php';
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
Route::get('/bookings/search', [BookingController::class, 'search'])->name('bookings.search');
Route::prefix('bookings')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::get('/create/{item_slug?}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/{slug}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/{slug}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/{slug}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/{slug}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // Booking Actions
    Route::post('/{slug}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/{slug}/on-rent', [BookingController::class, 'markAsOnRent'])->name('bookings.on-rent');
    Route::post('/{slug}/complete', [BookingController::class, 'markAsCompleted'])->name('bookings.complete');
    Route::post('/{slug}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Payment Routes
    Route::get('/{slug}/payment', [BookingController::class, 'showPaymentForm'])->name('bookings.payment');
    Route::post('/bookings/{slug}/process-payment', [BookingController::class, 'processPayment'])
        ->name('bookings.processPayment');
    Route::post('/payment/notification', [BookingController::class, 'handlePaymentNotification'])
        ->name('payment.notification');
    Route::get('/payment/return', [BookingController::class, 'paymentReturn'])
        ->name('payment.return');
});
