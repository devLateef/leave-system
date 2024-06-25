<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Route;
use App\Models\Role;
use App\Models\User;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/apply', [LeaveController::class, 'create'])->name('apply');
Route::post('/store', [LeaveController::class, 'store'])->name('store');
Route::get('/show/{leave}', [LeaveController::class, 'show'])->name('show-leave');
Route::post('/approve', [CommentController::class, 'store'])->name('store');
Route::get('/show-profile', [HomeController::class, 'show'])->name('show-profile');
Route::get('/edit-profile', [HomeController::class, 'edit'])->name('edit-profile');
// Route::get('/role', function () {
//     $user = User::find(1)->role;
//     return $user;
// });

Auth::routes();

route::get('/active', [LeaveController::class, 'index'])->name('active');
Route::get('/home', [HomeController::class, 'index'])->name('home');
