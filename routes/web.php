<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/apply', [LeaveController::class, 'create'])->name('apply');
// Route::post('/store', [LeaveController::class, 'store'])->name('store');
// Route::get('/show/{leave}', [LeaveController::class, 'show'])->name('show-leave');
// Route::get('/defered', [LeaveController::class, 'defered'])->name('defered');
// Route::get('/declined', [LeaveController::class, 'declined'])->name('declined');
// Route::get('/pending', [LeaveController::class, 'pending'])->name('pending');
// Route::delete('/edit/{leave}', [LeaveController::class, 'update'])->name('update');
// Route::post('/approve', [CommentController::class, 'store'])->name('approve');
// Route::post('/defer', [CommentController::class, 'storeDefer'])->name('defer');
// Route::post('/decline', [CommentController::class, 'storeDecline'])->name('decline');
// Route::get('/show-profile', [UserController::class, 'show'])->name('show-profile');
// Route::get('/edit-profile', [UserController::class, 'edit'])->name('edit-profile');


// Auth::routes();

// route::get('/active', [LeaveController::class, 'index'])->name('active');
// Route::get('/home', [HomeController::class, 'index'])->name('home');

// Welcome route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes
Auth::routes();

// Home route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Leave routes
Route::prefix('leaves')->middleware('auth')->group(function () {
    Route::get('/apply', [LeaveController::class, 'create'])->name('leaves.apply');
    Route::post('/store', [LeaveController::class, 'store'])->name('leaves.store');
    Route::get('/show/{leave}', [LeaveController::class, 'show'])->name('leaves.show');
    Route::get('/active', [LeaveController::class, 'approved'])->name('leaves.active');
    Route::get('/defered', [LeaveController::class, 'defered'])->name('leaves.defered');
    Route::get('/declined', [LeaveController::class, 'declined'])->name('leaves.declined');
    Route::get('/pending', [LeaveController::class, 'pending'])->name('leaves.pending');
    Route::get('/edit/{leave}', [LeaveController::class, 'edit'])->name('leaves.edit');
    Route::put('/update/{leave}', [LeaveController::class, 'update'])->name('leaves.update');
});

// Comment routes
Route::prefix('comments')->middleware('auth')->group(function () {
    Route::post('/approve', [CommentController::class, 'store'])->name('comments.approve');
    Route::post('/defer', [CommentController::class, 'storeDefer'])->name('comments.defer');
    Route::post('/decline', [CommentController::class, 'storeDecline'])->name('comments.decline');
});

// User profile routes
Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/show', [UserController::class, 'show'])->name('profile.show');
    Route::get('/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::get('/password', [UserController::class, 'createpass'])->name('profile.change');
    Route::post('/store', [UserController::class, 'store'])->name('profile.store');
    Route::get('/create', [UserController::class, 'create'])->name('profile.create');
});