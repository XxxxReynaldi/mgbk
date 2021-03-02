<?php

use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\WeekController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfilesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Models\Laporan;
use App\Models\Profile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
Route::get('profile/password', [ProfilesController::class, 'updatePassword'])->name('update-password.edit');
Route::resource('profile', ProfilesController::class);

Route::group(['middleware' => 'auth'], function () {
    // user
    Route::group(['middleware' => 'checkRole:user'], function () {
        Route::post('sekolah/new_sekolah', [SekolahController::class, 'newSekolahStore'])->name('new_sekolah.store');
        Route::get('sekolah/new_sekolah', [SekolahController::class, 'newSekolahIndex'])->name('new_sekolah.index');
    });

    // admin
    Route::group([
        'middleware' => 'checkRole:admin',
        'prefix' => 'admin',
        'as' => 'admin.',
    ], function () {
        Route::post('week/import', [WeekController::class, 'import'])->name('week.import');
        Route::resource('week', WeekController::class)->except(['create', 'show', 'edit']);

        Route::resource('kegiatan', KegiatanController::class);

        Route::post('sekolah/{sekolah}/verify', [SekolahController::class, 'verify'])->name('sekolah.verify');
        Route::resource('sekolah', SekolahController::class)->except(['create', 'show', 'edit']);

        Route::get('laporan/load-guru', [LaporanController::class, 'loadGuru'])->name('laporan.load-guru');
        Route::get('laporan/load-weeks', [LaporanController::class, 'loadWeeks'])->name('laporan.load-weeks');
        Route::post('laporan/cari', [LaporanController::class, 'cari'])->name('laporan.cari');
        Route::post('laporan/tb-semesteran', [LaporanController::class, 'tableSemester'])->name('laporan.tb-semesteran');

        Route::post('laporan/print/date/', [LaporanController::class, 'printByDate'])->name('laporan.print.date');
        Route::post('laporan/print/week', [LaporanController::class, 'printByWeek'])->name('laporan.print.week');
        Route::post('laporan/print/month', [LaporanController::class, 'printByMonth'])->name('laporan.print.month');

        Route::get('laporan/harian', [LaporanController::class, 'harian'])->name('laporan.harian');
        Route::get('laporan/mingguan', [LaporanController::class, 'mingguan'])->name('laporan.mingguan');
        Route::get('laporan/bulanan', [LaporanController::class, 'bulanan'])->name('laporan.bulanan');
        Route::get('laporan/semesteran', [LaporanController::class, 'semesteran'])->name('laporan.semesteran');
        Route::get('laporan/tahunan', [LaporanController::class, 'tahunan'])->name('laporan.tahunan');
    });
});


// Route::get('/dashboard', function () {
//     // ...
//     dd("ada di dashboard");
// })->middleware(['verified']);

Route::get('/read_profile', function () {
    // $user = User::find(2);

    // $profile = Profile::where('id_user', auth()->user()->id_user)->first();
    // dump($profile);
    // $profile = Profile::with('user')->where('id_user', auth()->user()->id_user)->first();
    // dump($profile);
    // $profile = Profile::with('user')->where('id_user', auth()->user()->id_user)->first();
    // dump($profile->user->name);

    // return $user;
    // return $user->profile()->get();
    // return $user->profile->nama_lengkap;

    $users = User::with('profile')->get();
    foreach ($users as $value) {
        dump($value);
        if ($value->profile != null) {
            dump($value->profile->nama_lengkap);
        }
    }

    // dd($users);
});

Route::get('/tes', function () {
    //     $reports = Laporan::with(['user', 'sekolah', 'kegiatan'])
    //         ->where('id_sekolah', '3')
    //         ->where('id_user', '11')
    //         ->where('tgl_transaksi', '2021-02-15')
    //         ->get();

    // $reports = Laporan::with(['user', 'sekolah', 'kegiatan'])
    //     ->where('id_sekolah', '3')
    //     ->where('id_user', '11')
    //     ->whereBetween('tgl_transaksi', [date("Y-m-d",  strtotime("2021 - 02 - 1")), date("Y-m-d",  strtotime("2021-02-7"))])
    //     ->get();
    // dd($reports);

    // $dateS = Carbon::now()->startOfMonth()->subMonth();
    // dd($dateS);

    // $year = "2021";
    // $start_date  =  date('Y-m-d', strtotime($year . "-01-01"));
    // $end_date    =  date('Y-m-d', strtotime($year . "-06-30"));

    // $jml = Laporan::with(['user', 'sekolah', 'kegiatan'])
    //     ->where('id_sekolah', '3')
    //     ->where('id_user', '11')
    //     ->whereYear('tgl_transaksi', $year)
    //     ->whereBetween('tgl_transaksi', [$start_date, $end_date])
    //     ->count();
    // dd($jml);
});
