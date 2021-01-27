<?php

use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\SekolahBaruController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['verified'])->name('home');
Route::get('/profile', [ProfilesController::class, 'index'])->name('profile');

Route::group(['middleware' => 'auth'], function () {

    Route::post('week/import', [WeekController::class, 'import'])->name('week.import');
    Route::resource('week', WeekController::class)->except(['create', 'show', 'edit']);

    Route::resource('kegiatan', KegiatanController::class);

    Route::post('sekolah/new_sekolah', [SekolahController::class, 'newSekolahStore'])->name('new_sekolah.store');
    Route::get('sekolah/new_sekolah', [SekolahController::class, 'newSekolahIndex'])->name('new_sekolah.index');
    Route::post('sekolah/{sekolah}/verify', [SekolahController::class, 'verify'])->name('sekolah.verify');
    Route::resource('sekolah', SekolahController::class)->except(['create', 'show', 'edit']);

    //
});

Route::get('/dashboard', function () {
    // ...
    dd("ada di dashboard");
})->middleware(['verified']);
