<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoombookController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/contact-us', function () {
    return view('contact');
})->name('contact');


// ---- Authentication ----
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login/user', [AuthController::class, 'userLogin'])->name('login.user');
Route::post('/login/employee', [AuthController::class, 'empLogin'])->name('login.employee');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// ---- User area ----
Route::middleware('auth.user')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/book', [HomeController::class, 'showBookForm'])->name('room.book');
    Route::post('/book', [HomeController::class, 'book'])->name('room.book.submit');

    Route::get('/user-panel', [UserDashboardController::class, 'panel'])->name('user_panel');
    Route::get('/user-panel/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user-panel/roombook', [UserDashboardController::class, 'roombook'])->name('user.roombook');
    Route::get('/user-panel/payment', [UserDashboardController::class, 'payment'])->name('user.payment');
    Route::get('/user-panel/profile', [UserDashboardController::class, 'profile'])->name('user.userprofile');
    Route::get('/user-panel/profile/edit', [UserDashboardController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('/user-panel/profile/edit', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/user-panel/profile/password', [UserDashboardController::class, 'editPassword'])->name('user.password.edit');
    Route::post('/user-panel/profile/password', [UserDashboardController::class, 'updatePassword'])->name('user.password.update');
    Route::get('/user-panel/invoice/{id}', [UserDashboardController::class, 'invoice'])->name('user.invoice');
});

// ---- Admin area ----
Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'panel'])->name('panel');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Room booking
    Route::get('/roombook', [RoombookController::class, 'index'])->name('roombook');
    Route::get('/roombook/{id}/edit', [RoombookController::class, 'edit'])->name('roombook.edit');
    Route::post('/roombook/{id}/edit', [RoombookController::class, 'update'])->name('roombook.update');
    Route::get('/roombook/{id}/confirm', [RoombookController::class, 'confirm'])->name('roombook.confirm');
    Route::get('/roombook/{id}/delete', [RoombookController::class, 'destroy'])->name('roombook.delete');
    Route::post('/roombook/export', [RoombookController::class, 'export'])->name('roombook.export');

    // Payment / invoice
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
    Route::get('/payment/{id}/delete', [PaymentController::class, 'destroy'])->name('payment.delete');
    Route::get('/payment/{id}/invoice', [PaymentController::class, 'invoice'])->name('payment.invoice');

    // Rooms
    // Rooms
    Route::get('/room', [RoomController::class, 'index'])->name('room');
    Route::post('/room', [RoomController::class, 'store'])->name('room.store');

    Route::get('/room/{id}/edit', [RoomController::class, 'edit'])->name('room.edit');
    Route::post('/room/{id}/update', [RoomController::class, 'update'])->name('room.update');

    Route::post('/room/bulk-update', [RoomController::class, 'bulkUpdate'])->name('room.bulk_update');

    Route::delete('/room/{id}', [RoomController::class, 'destroy'])
        ->name('room.delete');
    Route::get('/room-price/{type}', function ($type) {

        return \App\Models\Room::where('type', $type)
            ->select('type', 'price', 'bedding')
            ->get();

    });
    Route::get(
        '/room-detail/{type}',
        [HomeController::class, 'roomDetail']
    )
        ->name('room.detail');

    // Staff
    Route::get('/staff', [StaffController::class, 'index'])->name('staff');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{id}/delete', [StaffController::class, 'destroy'])->name('staff.delete');
});
