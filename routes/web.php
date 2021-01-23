<?php

use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\WeekController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return redirect('login');
    // redirect('/home');
});

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [ProfilesController::class, 'index'])->name('profile');

Route::group(['middleware' => 'auth'], function () {

    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('week', WeekController::class);
    Route::resource('sekolah', SekolahController::class);
    //
});
