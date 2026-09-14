<?php

use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\HelpController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\InfoController;
use App\Http\Controllers\Customer\JourneyController;
use App\Http\Controllers\Customer\MyTripsController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\SearchController;
use App\Http\Controllers\Customer\TicketController;
use App\Http\Controllers\Customer\TrackController;
use App\Http\Controllers\Customer\TripController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');

Route::prefix('booking/{booking}')->name('booking.')->group(function () {
    Route::get('/seats', [BookingController::class, 'seats'])->name('seats');
    Route::post('/seats', [BookingController::class, 'storeSeats'])->name('seats.store');
    Route::get('/passengers', [BookingController::class, 'passengers'])->name('passengers');
    Route::post('/passengers', [BookingController::class, 'storePassengers'])->name('passengers.store');
    Route::get('/review', [BookingController::class, 'review'])->name('review');
    Route::get('/payment', [BookingController::class, 'payment'])->name('payment');
    Route::post('/payment', [BookingController::class, 'storePayment'])->name('payment.store');
    Route::get('/payment-status', [BookingController::class, 'paymentStatus'])->name('payment-status');
});

Route::get('/tickets/{code}', [TicketController::class, 'show'])->name('tickets.show');

Route::get('/my-trips', [MyTripsController::class, 'index'])->name('my-trips.index');

Route::prefix('journeys/{journey}')->name('journeys.')->group(function () {
    Route::get('/', [JourneyController::class, 'show'])->name('show');
    Route::get('/track', [JourneyController::class, 'track'])->name('track');
});

Route::get('/classes', [InfoController::class, 'classes'])->name('classes.index');
Route::get('/routes', [InfoController::class, 'routes'])->name('routes.index');
Route::get('/about', [InfoController::class, 'about'])->name('about.index');

Route::get('/help', [HelpController::class, 'index'])->name('help.index');
Route::post('/help', [HelpController::class, 'store'])->name('help.store');
Route::get('/help/{help}', [HelpController::class, 'show'])->name('help.show');

Route::get('/profile', [CustomerProfileController::class, 'index'])->name('profile.index');

Route::get('/track', [TrackController::class, 'index'])->name('track.index');
Route::post('/track', [TrackController::class, 'lookup'])->name('track.lookup');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
