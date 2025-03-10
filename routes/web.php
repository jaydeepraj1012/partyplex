<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

// Venue routes
Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');
Route::get('/venues/search', [VenueController::class, 'search'])->name('venues.search');
Route::get('/venues/{venue}', [VenueController::class, 'show'])->name('venues.show');

// Authentication required routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Venue management (for venue owners)
    Route::get('/venues-create', [VenueController::class, 'create'])->name('venues.create');
    Route::post('/venues', [VenueController::class, 'store'])->name('venues.store');
    Route::get('/venues/{venue}/edit', [VenueController::class, 'edit'])->name('venues.edit');
    Route::put('/venues/{venue}', [VenueController::class, 'update'])->name('venues.update');
    Route::delete('/venues/{venue}', [VenueController::class, 'destroy'])->name('venues.destroy');
    Route::patch('/venues/{venue}/active', [VenueController::class, 'toggleActive'])->name('venues.toggle-active');

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{venue}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/{venue}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Venue owner booking management
    Route::patch('/bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');

    // Reviews
    Route::post('/reviews/{booking}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/users/{user}/status', [MessageController::class, 'getUserStatus'])->name('users.status');
    Route::post('/messages/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::post('/messages/booking/{booking}', [MessageController::class, 'storeBookingMessage'])->name('messages.booking.store');

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/booking/{booking}', [PaymentController::class, 'processBookingPayment'])->name('payments.process');
    Route::get('/payments/success', [PaymentController::class, 'success'])->name('payments.success');
    Route::get('/payments/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');

    // Venue owner specific routes (for venue management)
    Route::middleware(['auth', 'role_or_permission:venue-owner|edit venues|manage venues'])->group(function () {
        Route::get('/my-venues', [VenueController::class, 'myVenues'])->name('venues.my-venues');
    });
});

// Admin routes
Route::middleware(['auth', 'role_or_permission:admin|super-admin|manage admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Venue approval
    Route::get('/venues/pending', [AdminController::class, 'pendingVenues'])->name('venues.pending');
    Route::patch('/venues/{venue}/approve', [VenueController::class, 'approve'])->name('venues.approve');
    Route::patch('/venues/{venue}/featured', [VenueController::class, 'toggleFeatured'])->name('venues.toggle-featured');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    
    // Review moderation
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');
    Route::patch('/reviews/{review}/approve', [AdminController::class, 'approveReview'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('reviews.destroy');
    
    // Booking management
    Route::get('/bookings/pending', [AdminController::class, 'pendingBookings'])->name('bookings.pending');
    
    // Reports
    Route::get('/reports/bookings', [AdminController::class, 'bookingReports'])->name('reports.bookings');
    Route::get('/reports/revenue', [AdminController::class, 'revenueReports'])->name('reports.revenue');
    Route::get('/reports/users', [AdminController::class, 'userReports'])->name('reports.users');
});

Route::get('/test-route', function() {
    return 'Test route is working!';
});


require __DIR__.'/auth.php';


// URL: http://127.0.0.1:8000/login
// Email: admin@partyplex.com
// Password: password