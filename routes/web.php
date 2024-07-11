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
    return view('index');
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
    Route::get('/show/{leave}/approval', [LeaveController::class, 'approvalNote'])->name('leaves.approval');
    Route::get('/active', [LeaveController::class, 'approved'])->name('leaves.active');
    Route::get('/data', [LeaveController::class, 'getLeaveApplications'])->name('leaves.data');
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
    Route::put('/password/{user}', [UserController::class, 'updatePass'])->name('profile.update-password');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('profile.update-user');
    Route::get('/user-detail/{user}', [UserController::class, 'showUserDetail'])->name('profile.user-detail');
    Route::get('/users', [UserController::class, 'getAllUsers'])->name('profile.all-users');
    Route::get('/hods', [UserController::class, 'getAllHods'])->name('profile.all-hods');
    Route::get('/users/{department}', [UserController::class, 'getUsersByDepartment']);
    Route::post('/update-role', [UserController::class, 'updateRole'])->name('profile.update-role');
    Route::post('/assign-admin', [UserController::class, 'assignAdmin'])->name('profile.assign-admin');
    Route::get('/assign-hod', [UserController::class, 'getDepartments'])->name('profile.assign');
    Route::get('/make-admin', [UserController::class, 'getAdminDepartment'])->name('profile.make-admin');
    Route::post('/store', [UserController::class, 'store'])->name('profile.store');
    Route::get('/create', [UserController::class, 'create'])->name('profile.create');
    Route::get('/data/user', [UserController::class, 'getUsers'])->name('profile.users');
    Route::delete('/delete/{user}', [UserController::class, 'destroy'])->name('profile.delete');
});