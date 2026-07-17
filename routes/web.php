<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoombookController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public reservation request (guests can book without an account; admin confirms it)
Route::post('/home/book', [HomeController::class, 'book'])->name('home.book');

// ---- Guest panel (wired to the logged-in guest's own data) ----
Route::middleware('auth.user')->group(function () {
    Route::get('/user-panel', [UserController::class, 'panel'])->name('user_panel');
    Route::get('/user-panel/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user-panel/roombook', [UserController::class, 'roombook'])->name('user.roombook');
    Route::get('/user-panel/payment', [UserController::class, 'payment'])->name('user.payment');
    Route::get('/user-panel/profile', [UserController::class, 'profile'])->name('user.userprofile');
    Route::get('/user-panel/invoice/{id}', [UserController::class, 'invoice'])->name('user.invoice');
});

// ---- Authentication (was index.php / logout.php) ----
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login/user', [AuthController::class, 'userLogin'])->name('login.user');
Route::post('/login/employee', [AuthController::class, 'empLogin'])->name('login.employee');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// ---- Admin area (was admin/*.php) ----
Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'panel'])->name('panel');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Room booking
    Route::get('/roombook', [RoombookController::class, 'index'])->name('roombook');
    Route::post('/roombook', [RoombookController::class, 'store'])->name('roombook.store');
    Route::get('/roombook/{id}/edit', [RoombookController::class, 'edit'])->name('roombook.edit');
    Route::post('/roombook/{id}/edit', [RoombookController::class, 'update'])->name('roombook.update');
    Route::get('/roombook/{id}/confirm', [RoombookController::class, 'confirm'])->name('roombook.confirm');
    Route::get('/roombook/{id}/delete', [RoombookController::class, 'destroy'])->name('roombook.delete');
    Route::post('/roombook/export', [RoombookController::class, 'export'])->name('roombook.export');

    // Payment / POS checkout / invoice
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
    Route::get('/payment/{id}/settle', [PaymentController::class, 'settleForm'])->name('payment.settle');
    Route::post('/payment/{id}/settle', [PaymentController::class, 'settle'])->name('payment.settle.store');
    Route::get('/payment/{id}/delete', [PaymentController::class, 'destroy'])->name('payment.delete');
    Route::get('/payment/{id}/invoice', [PaymentController::class, 'invoice'])->name('payment.invoice');

    // Rooms
    Route::get('/room', [RoomController::class, 'index'])->name('room');
    Route::post('/room', [RoomController::class, 'store'])->name('room.store');
    Route::get('/room/{id}/delete', [RoomController::class, 'destroy'])->name('room.delete');

    // Staff
    Route::get('/staff', [StaffController::class, 'index'])->name('staff');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{id}/delete', [StaffController::class, 'destroy'])->name('staff.delete');
});
