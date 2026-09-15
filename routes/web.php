<?php

use App\Http\Controllers\Customer\InvoiceController;
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
use App\Http\Controllers\Admin\BusController as AdminBusController;
use App\Http\Controllers\Admin\BusIssueController as AdminBusIssueController;
use App\Http\Controllers\Admin\AnalisaController as AdminAnalisaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HelpController as AdminHelpController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\AdminRouteController as AdminRouteController;
use App\Http\Controllers\Admin\TripController as AdminTripController;
use App\Http\Controllers\Admin\TripSeatController as AdminTripSeatController;
use App\Http\Controllers\Admin\TripWizardController as AdminTripWizardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/perjalanan', [SearchController::class, 'index'])->name('perjalanan.index');

Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');
Route::get('/perjalanan/{trip}', [TripController::class, 'show'])->name('perjalanan.show');
Route::get('/perjalanan/{trip}/seat-statuses', [TripController::class, 'seatStatuses'])->name('perjalanan.seat-statuses');

// Seat selection (trip-based)
Route::get('/trips/{trip}/seats', [BookingController::class, 'seats'])->name('booking.seats');
Route::post('/trips/{trip}/seats', [BookingController::class, 'storeSeats'])->name('booking.seats.store');

// Booking flow (booking-based, after seats are held)
Route::prefix('booking/{booking}')->name('booking.')->group(function () {
    Route::get('/passengers', [BookingController::class, 'passengers'])->name('passengers');
    Route::post('/passengers', [BookingController::class, 'storePassengers'])->name('passengers.store');
    Route::get('/review', [BookingController::class, 'review'])->name('review');
    Route::get('/payment', [BookingController::class, 'payment'])->name('payment');
    Route::post('/payment', [BookingController::class, 'storePayment'])->name('payment.store');
    Route::get('/payment-status', [BookingController::class, 'paymentStatus'])->name('payment-status');
});

// Track & E-Ticket
Route::get('/track', [TrackController::class, 'index'])->name('track.index');
Route::post('/track', [TrackController::class, 'lookup'])->name('track.lookup');
Route::get('/track/{code}', [TrackController::class, 'show'])->name('track.show');
Route::post('/track/{code}/payment', [TrackController::class, 'updatePayment'])->name('track.update-payment');

Route::get('/tickets/{code}', [TicketController::class, 'show'])->name('tickets.show');

// Invoice
Route::get('/booking/{code}/invoice', [InvoiceController::class, 'view'])->name('invoice.view');
Route::get('/booking/{code}/invoice/download', [InvoiceController::class, 'downloadPdf'])->name('invoice.download');
Route::get('/booking/{code}/invoice/image', [InvoiceController::class, 'downloadImage'])->name('invoice.image');

Route::get('/my-trips', [MyTripsController::class, 'index'])->name('my-trips.index');
Route::post('/my-trips/search', [MyTripsController::class, 'search'])->name('my-trips.search');

Route::prefix('journeys/{journey}')->name('journeys.')->group(function () {
    Route::get('/', [JourneyController::class, 'show'])->name('show');
    Route::get('/track', [JourneyController::class, 'track'])->name('track');
});

Route::get('/classes', [InfoController::class, 'classes'])->name('classes.index');
Route::get('/routes', [InfoController::class, 'routes'])->name('routes.index');
Route::get('/about', [InfoController::class, 'about'])->name('about.index');

// Help
Route::get('/help', [HelpController::class, 'index'])->name('help.index');
Route::post('/help', [HelpController::class, 'store'])->name('help.store');
Route::get('/help/{session}', [HelpController::class, 'show'])->name('help.show');
Route::post('/help/{session}/reply', [HelpController::class, 'reply'])->name('help.reply');

Route::get('/profile', [CustomerProfileController::class, 'index'])->middleware('auth')->name('profile.index');
Route::patch('/profile', [CustomerProfileController::class, 'update'])->middleware('auth')->name('profile.update');
Route::get('/profile/password', [CustomerProfileController::class, 'passwordForm'])->middleware('auth')->name('profile.password');
Route::put('/profile/password', [CustomerProfileController::class, 'passwordUpdate'])->middleware('auth')->name('profile.password.update');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('locations', AdminLocationController::class)->except(['show']);
    Route::resource('buses', AdminBusController::class)->except(['show']);
    Route::patch('/buses/{bus}/status', [AdminBusController::class, 'updateStatus'])->name('buses.update-status');
    Route::get('/buses/{bus}/issues', [AdminBusIssueController::class, 'index'])->name('buses.issues.index');
    Route::get('/buses/{bus}/issues/create', [AdminBusIssueController::class, 'create'])->name('buses.issues.create');
    Route::post('/buses/{bus}/issues', [AdminBusIssueController::class, 'store'])->name('buses.issues.store');
    Route::patch('/buses/{bus}/issues/{issue}/status', [AdminBusIssueController::class, 'updateStatus'])->name('buses.issues.update-status');

    // Route management
    Route::resource('routes', AdminRouteController::class)->except(['show']);
    Route::get('/routes-filter', [AdminRouteController::class, 'filterByService'])->name('routes.filter');

    // Trip management
    Route::get('/trips', [AdminTripController::class, 'index'])->name('trips.index');
    Route::get('/trips/create/{step}', [AdminTripWizardController::class, 'create'])->whereNumber('step')->name('trips.create');
    Route::post('/trips/create/step-1', [AdminTripWizardController::class, 'storeStepOne'])->name('trips.store-step-1');
    Route::post('/trips/create/step-2', [AdminTripWizardController::class, 'storeStepTwo'])->name('trips.store-step-2');
    Route::post('/trips/create/step-3', [AdminTripWizardController::class, 'storeStepThree'])->name('trips.store-step-3');
    Route::post('/trips/create/step-4', [AdminTripWizardController::class, 'storeStepFour'])->name('trips.store-step-4');
    Route::post('/trips/create/step-5', [AdminTripWizardController::class, 'storeStepFive'])->name('trips.store-step-5');
    Route::get('/trips/{trip}/edit', [AdminTripController::class, 'edit'])->name('trips.edit');
    Route::put('/trips/{trip}', [AdminTripController::class, 'update'])->name('trips.update');
    Route::delete('/trips/{trip}', [AdminTripController::class, 'destroy'])->name('trips.destroy');
    Route::get('/trips/{trip}/seats', [AdminTripController::class, 'seats'])->name('trips.seats');
    Route::patch('/trip-seats/{seat}/toggle-maintenance', [AdminTripSeatController::class, 'toggleMaintenance'])->name('trip-seats.toggle');

    // Analisa
    Route::get('/analisa', [AdminAnalisaController::class, 'index'])->name('analisa.index');

    // Transactions
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{booking}', [AdminTransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{booking}/approve', [AdminTransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{booking}/reject', [AdminTransactionController::class, 'reject'])->name('transactions.reject');

    // Help
    Route::get('/help', [AdminHelpController::class, 'index'])->name('help.index');
    Route::get('/help/{session}', [AdminHelpController::class, 'show'])->name('help.show');
    Route::post('/help/{session}/accept', [AdminHelpController::class, 'accept'])->name('help.accept');
    Route::post('/help/{session}/reply', [AdminHelpController::class, 'reply'])->name('help.reply');
    Route::post('/help/{session}/close', [AdminHelpController::class, 'close'])->name('help.close');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
