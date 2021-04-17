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

        Route::group([
            'prefix' => 'user',
            'as' => 'user.',
        ], function () {

            Route::get('laporan/load-weeks', [LaporanController::class, 'loadWeeks'])->name('laporan.load-weeks');

            Route::get('laporan/harian', [LaporanController::class, 'index'])->name('laporan.harian');
            Route::get('laporan/mingguan', [LaporanController::class, 'index'])->name('laporan.mingguan');
            Route::get('laporan/bulanan', [LaporanController::class, 'index'])->name('laporan.bulanan');
            Route::get('laporan/semesteran', [LaporanController::class, 'index'])->name('laporan.semesteran');
            Route::get('laporan/tahunan', [LaporanController::class, 'index'])->name('laporan.tahunan');
            Route::post('laporan/cari', [LaporanController::class, 'cari'])->name('laporan.cari');
            Route::post('laporan/tb-bulanan', [LaporanController::class, 'tableBST'])->name('laporan.tb-bulanan');
            Route::post('laporan/tb-semesteran', [LaporanController::class, 'tableBST'])->name('laporan.tb-semesteran');
            Route::post('laporan/tb-tahunan', [LaporanController::class, 'tableBST'])->name('laporan.tb-tahunan');

            Route::post('laporan/import', [LaporanController::class, 'import'])->name('laporan.import');
            Route::post('laporan/print/date', [LaporanController::class, 'printByDate'])->name('laporan.print.date');
            Route::post('laporan/print/week', [LaporanController::class, 'printByWeek'])->name('laporan.print.week');
            Route::post('laporan/print/month', [LaporanController::class, 'printByMonth'])->name('laporan.print.month');
            Route::post('laporan/print/semester', [LaporanController::class, 'printBySemester'])->name('laporan.print.semester');
            Route::post('laporan/print/year', [LaporanController::class, 'printByYear'])->name('laporan.print.year');
            Route::post('laporan/print/tes', [LaporanController::class, 'printByTes'])->name('laporan.print.tes');
            Route::post('laporan/print/tesMingguan', [LaporanController::class, 'printByTesMingguan'])->name('laporan.print.tesMingguan');
        });
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
        Route::post('laporan/tb-bulanan', [LaporanController::class, 'tableBST'])->name('laporan.tb-bulanan');
        Route::post('laporan/tb-semesteran', [LaporanController::class, 'tableBST'])->name('laporan.tb-semesteran');
        Route::post('laporan/tb-tahunan', [LaporanController::class, 'tableBST'])->name('laporan.tb-tahunan');

        Route::post('laporan/print/date', [LaporanController::class, 'printByDate'])->name('laporan.print.date');
        Route::post('laporan/print/week', [LaporanController::class, 'printByWeek'])->name('laporan.print.week');
        Route::post('laporan/print/month', [LaporanController::class, 'printByMonth'])->name('laporan.print.month');
        Route::post('laporan/print/semester', [LaporanController::class, 'printBySemester'])->name('laporan.print.semester');
        Route::post('laporan/print/year', [LaporanController::class, 'printByYear'])->name('laporan.print.year');

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

    // Query laporan By Date
    // $laporan = DB::table('laporan')
    //     ->Join('kegiatan', 'laporan.id_kegiatan', '=', 'kegiatan.id_kegiatan')
    //     ->Join('sekolah', 'laporan.id_sekolah', '=', 'sekolah.id_sekolah')
    //     ->Join('users', 'laporan.id_user', '=', 'users.id_user')
    //     ->Join('profiles', 'users.id_user', '=', 'profiles.id_user')
    //     ->select('laporan.*', 'kegiatan.*', 'sekolah.nama_sekolah', 'profiles.*')
    //     ->where('profiles.id_user', $request->get('id_user-p'))
    //     ->where('laporan.id_user', $request->get('id_user-p'))
    //     ->where('laporan.id_sekolah', $request->get('id_sekolah-p'))
    //     ->where('laporan.tgl_transaksi', $request->get('tgl_transaksi-p'));


    // Query Laporan By Month, Semester, Year
    // $result = DB::select("select Detail_Laporan.id_usr, kegiatan.kegiatan, 
    //     SUM(ekuivalen) as jumlah_ekuivalen, count(Detail_Laporan.id_keg) as jumlah_kegiatan 
    //     From (select laporan.id_user as id_usr,laporan.id_kegiatan as id_keg,laporan.id_sekolah 
    //     From laporan where YEAR(laporan.tgl_transaksi) = '$tahun' and MONTH(laporan.tgl_transaksi) = '$bulan'
    //     and id_user = '$id_user' and id_sekolah = '$id_sekolah') as Detail_Laporan 
    //     inner  JOIN kegiatan on Detail_Laporan.id_keg = kegiatan.id_kegiatan 
    //     GROUP by Detail_Laporan.id_usr, Detail_Laporan.id_kegiatan");

    // dd($result);


    $laporan = Laporan::with(['sekolah', 'user.profile', 'kegiatan'])
        ->where('id_user', '6')
        ->where('id_sekolah', '4')
        ->where('tgl_transaksi', '2021-03-22')
        ->get();
    $laporan[0]->sekolah->exists();

    foreach ($laporan as $report) {
        dump($report->kegiatan->kegiatan);
        dump($report->kegiatan()->count());
        dump($report->kegiatan()->sum('ekuivalen'));
        // echo $report->kegiatan->kegiatan . "<br>";
        // echo $report->kegiatan->count() . "<br>";
        // echo $report->kegiatan->sum('ekuivalen');
    }

    // $kegiatan = DB::table('kegiatan')->select('kegiatan')->get();
    // $activity = [];
    // foreach ($kegiatan as $key => $value) {
    //     // dump($value->kegiatan);
    //     array_push($activity, $value->kegiatan);
    // }
    // dd($activity);
    // dd(collect($kegiatan));
});
