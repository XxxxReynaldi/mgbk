<?php

namespace App\Http\Controllers;

use App\Imports\ReportImport;
use App\Models\Laporan;
use App\Models\Profile;
use App\Models\Sekolah;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_user = Auth::user()->id_user;
        $profile = Profile::where('id_user', $id_user)->first();

        $file = null;

        $years = null;
        $weeks = null;

        if (request()->segment(3) == 'harian') {
            $file = "harian";
        } else if (request()->segment(3) == 'mingguan') {

            $years   = Week::pluck('year', 'year');
            $weeks   = Week::pluck('week', 'id_week');

            $file = "mingguan";
        } else if (request()->segment(3) == 'bulanan') {
            $file = "bulanan";
        } else if (request()->segment(3) == 'semesteran') {
            $file = "semesteran";
        } else if (request()->segment(3) == 'tahunan') {
            $file = "tahunan";
        }

        return view('laporan.guru.' . $file, compact('id_user', 'profile', 'years', 'weeks'));
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file_excel_report'       => 'required|file|mimes:xls,xlsx|max:2048',
        ]);
        $file       = $request->file('file_excel_report');
        $namaFile   = $file->getClientOriginalName();

        // $statImport = Excel::import(new ReportImport, $file);
        // dump($statImport);

        Excel::import(new ReportImport, $file);
        // Storage::makeDirectory('public/dokumenReport/' . $namaFile);

        return redirect()->back()->with('status', 'Data Laporan berhasil diimport !');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function show(Laporan $laporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function edit(Laporan $laporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laporan $laporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laporan $laporan)
    {
        //
    }

    public function harian()
    {
        $schools = Sekolah::pluck('nama_sekolah', 'id_sekolah');

        return view('laporan.admin.harian', compact('schools'));
    }

    public function mingguan()
    {
        $schools = Sekolah::pluck('nama_sekolah', 'id_sekolah');
        $years   = Week::pluck('year', 'year');
        $weeks   = Week::pluck('week', 'id_week');

        return view('laporan.admin.mingguan', compact('schools', 'years', 'weeks'));
    }

    public function bulanan()
    {
        $schools = Sekolah::pluck('nama_sekolah', 'id_sekolah');

        return view('laporan.admin.bulanan', compact('schools'));
    }

    public function semesteran(Request $request)
    {
        $schools = Sekolah::pluck('nama_sekolah', 'id_sekolah');

        return view('laporan.admin.semesteran', compact('schools'));
    }

    public function tahunan()
    {
        $schools = Sekolah::pluck('nama_sekolah', 'id_sekolah');

        return view('laporan.admin.tahunan', compact('schools'));
    }

    public function loadGuru(Request $request)
    {
        $guru = Profile::with('user')->where('id_sekolah', $request->get('id_sekolah'))
            ->pluck('nama_lengkap', 'id_user');

        return response()->json($guru);
    }

    public function loadWeeks(Request $request)
    {
        $weeks = Week::where('year', $request->get('year'))
            ->pluck('week', 'id_week');

        return response()->json($weeks);
    }

    public function cari(Request $request)
    {
        $reports = Laporan::with(['user', 'sekolah', 'kegiatan']);
        return Datatables::eloquent($reports)
            ->addIndexColumn()
            ->addColumn('kegiatan', function (Laporan $laporan) {
                return $laporan->kegiatan->kegiatan;
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('id_sekolah')) {
                    $query->where('id_sekolah', $request->id_sekolah);
                }

                if ($request->has('id_user')) {
                    $query->where('id_user', $request->id_user);
                }

                if ($request->has('laporan') && $request->get('laporan') == "harian") {
                    if ($request->has('tgl_transaksi')) {
                        $query->where('tgl_transaksi', $request->tgl_transaksi);
                    }
                } else if ($request->has('laporan') && $request->get('laporan') == "mingguan") {
                    if ($request->has('id_week') && $request->get('id_week') != "") {
                        $week = DB::table('weeks')
                            ->where('id_week', $request->id_week)
                            ->first();
                        $tgl_awal  = date('Y-m-d', strtotime($week->start_date));
                        $tgl_akhir = date('Y-m-d', strtotime($week->end_date));

                        $query->whereBetween('tgl_transaksi', [$tgl_awal, $tgl_akhir]);
                    }
                } else if ($request->has('laporan') && $request->get('laporan') == "bulanan") {
                    if ($request->has('year') && $request->has('month') && $request->get('year') != "") {
                        $query->whereYear('tgl_transaksi', $request->year);
                        $query->whereMonth('tgl_transaksi', $request->month);
                    } else if ($request->has('month')) {
                        $query->whereMonth('tgl_transaksi', $request->month);
                    }
                } else if ($request->has('laporan') && $request->get('laporan') == "semester") {
                    if ($request->has('year') && $request->has('semester') && $request->get('year') != "" && $request->get('semester') != "") {
                        if ($request->semester == "1") {
                            $start_date  =  date('Y-m-d', strtotime($request->year . "-01-01"));
                            $end_date    =  date('Y-m-d', strtotime($request->year . "-06-30"));
                        } else {
                            $start_date  =  date('Y-m-d', strtotime($request->year . "-07-01"));
                            $end_date    =  date('Y-m-d', strtotime($request->year . "-12-31"));
                        }
                        $query->whereYear('tgl_transaksi', $request->year);
                        $query->whereBetween('tgl_transaksi', [$start_date, $end_date]);
                    }
                } else if ($request->has('laporan') && $request->get('laporan') == "tahunan") {
                    if ($request->has('year') && $request->get('year') != "") {
                        $query->whereYear('tgl_transaksi', $request->year);
                    }
                }
            })
            ->make(true);
        //
    }

    public function tableBST(Request $request)
    {
        $laporan = Laporan::with(['user', 'sekolah', 'kegiatan']);

        return datatables()->of($laporan)
            ->addIndexColumn()
            ->addColumn('kegiatan', function (Laporan $laporan) {
                return $laporan->kegiatan->kegiatan;
            })
            ->addColumn('jumlah', function ($query) {
                return $query->kegiatan->kegiatan;
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('id_sekolah')) {
                    $query->where('id_sekolah', $request->id_sekolah);
                }

                if ($request->has('id_user')) {
                    $query->where('id_user', $request->id_user);
                }

                if ($request->has('laporan') && $request->get('laporan') == "bulanan") {
                    if ($request->has('year') && $request->has('month') && $request->get('year') != "") {
                        $query->whereYear('tgl_transaksi', $request->year);
                        $query->whereMonth('tgl_transaksi', $request->month);
                    } else if ($request->has('month')) {
                        $query->whereMonth('tgl_transaksi', $request->month);
                    }
                } else if ($request->has('year') && $request->has('semester') && $request->get('year') != "" && $request->get('semester') != "") {
                    if ($request->semester == "1") {
                        $start_date  =  date('Y-m-d', strtotime($request->year . "-01-01"));
                        $end_date    =  date('Y-m-d', strtotime($request->year . "-06-30"));
                    } else {
                        $start_date  =  date('Y-m-d', strtotime($request->year . "-07-01"));
                        $end_date    =  date('Y-m-d', strtotime($request->year . "-12-31"));
                    }
                    $query->whereYear('tgl_transaksi', $request->year);
                    $query->whereBetween('tgl_transaksi', [$start_date, $end_date]);
                } else if ($request->has('laporan') && $request->get('laporan') == "tahunan") {
                    if ($request->has('year') && $request->get('year') != "") {
                        $query->whereYear('tgl_transaksi', $request->year);
                    }
                }
            })
            ->make(true);
        //
    }

    public function printByDate(Request $request)
    {
        if ($request->get('tgl_transaksi-p') == null) {
            return redirect()->back()->with('status', 'Print gagal, Lakukan filtering harian terlebih dahulu !');
        }

        $laporan = Laporan::with(['sekolah', 'user.profile', 'kegiatan']);
        $laporan->where('id_user', $request->get('id_user-p'));
        $laporan->where('id_sekolah', $request->get('id_sekolah-p'));
        $laporan->where('tgl_transaksi', $request->get('tgl_transaksi-p'));

        $reports = $laporan->get();
        $guru = $laporan->first();
        // dd([$reports, $guru]);
        if ($guru == null) {
            return abort(404, 'Maaf, data Tidak Ditemukan');
        }

        // return view('laporan.print.harian', compact('guru', 'reports'));
        $namaLengkap = $guru->user->profile->nama_lengkap;

        $pdf = PDF::loadView('laporan.print.harian', compact('guru', 'reports'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('laporan-harian_' . $namaLengkap . '.pdf');
        // return $pdf->stream();
    }

    public function printByWeek(Request $request)
    {
        if ($request->get('id_week-p') == null) {
            return redirect()->back()->with('status', 'Print gagal, Lakukan filtering mingguan terlebih dahulu !');
        }
        $week = DB::table('weeks')
            ->where('id_week', $request->get('id_week-p'))
            ->first();
        $tgl_awal  = date('Y-m-d', strtotime($week->start_date));
        $tgl_akhir = date('Y-m-d', strtotime($week->end_date));

        $laporan = Laporan::with(['sekolah', 'user.profile', 'kegiatan']);
        $laporan->where('id_user', $request->get('id_user-p'));
        $laporan->where('id_sekolah', $request->get('id_sekolah-p'));
        $laporan->whereBetween('tgl_transaksi', [$tgl_awal, $tgl_akhir]);

        $reports = $laporan->get();
        $guru = $laporan->first();
        // dd([$reports, $guru, $week->week]);

        if ($guru == null) {
            return abort(404, 'Maaf, data Tidak Ditemukan');
        }

        // return view('laporan.print.mingguan', compact('guru', 'reports', 'week'));
        $namaLengkap = $guru->user->profile->nama_lengkap;

        $pdf = PDF::loadView('laporan.print.mingguan', compact('guru', 'reports', 'week'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('laporan-mingguan_' . $namaLengkap . '.pdf');
        // return $pdf->stream();
    }

    public function printByMonth(Request $request)
    {
        $year      = $request->get('year-p');
        $month      = $request->get('month-p');
        $id_user    = $request->get('id_user-p');
        $id_sekolah = $request->get('id_sekolah-p');

        if ($month == null || $year == null) {
            return redirect()->back()->with('status', 'Print gagal, Lakukan filtering bulanan terlebih dahulu !');
        }

        $laporan = DB::table('laporan')
            ->Join('kegiatan', 'laporan.id_kegiatan', '=', 'kegiatan.id_kegiatan')
            ->Join('sekolah', 'laporan.id_sekolah', '=', 'sekolah.id_sekolah')
            ->Join('users', 'laporan.id_user', '=', 'users.id_user')
            ->Join('profiles', 'users.id_user', '=', 'profiles.id_user')
            ->select(
                'laporan.id_user',
                'laporan.id_kegiatan',
                'laporan.tgl_transaksi',
                'kegiatan.id_kegiatan',
                'kegiatan.kegiatan',
                'sekolah.nama_sekolah',
                'profiles.nama_lengkap',
                'profiles.logo_sekolah',
                'profiles.alamat_sekolah',
                'profiles.tambahan_informasi',
                'profiles.kelas_pengampu',
                DB::raw('COUNT(laporan.id_laporan) as jumlah_kegiatan'),
                DB::raw('SUM(ekuivalen) as jumlah_ekuivalen')
            )
            ->where('laporan.id_user', $id_user)
            ->where('laporan.id_sekolah', $id_sekolah)
            ->groupBy(
                'laporan.id_user',
                'laporan.id_kegiatan',
                'laporan.tgl_transaksi',
                'kegiatan.id_kegiatan',
                'kegiatan.kegiatan',
                'sekolah.nama_sekolah',
                'profiles.nama_lengkap',
                'profiles.logo_sekolah',
                'profiles.alamat_sekolah',
                'profiles.tambahan_informasi',
                'profiles.kelas_pengampu',
            )
            ->orderBy('laporan.id_laporan', 'desc');
        $laporan->whereYear('tgl_transaksi', $year);
        $laporan->whereMonth('tgl_transaksi', $month);
        $reports = $laporan->get();
        $guru = $laporan->first();
        // dd([$reports, $guru]);

        if ($guru == null) {
            return abort(404, 'Maaf, data Tidak Ditemukan');
        }
        // return view('laporan.print.bulanan', compact('guru', 'reports'));
        $namaLengkap = $guru->nama_lengkap;

        $pdf = PDF::loadView('laporan.print.bulanan', compact('guru', 'reports'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('laporan-bulanan' . $namaLengkap . '.pdf');
    }

    public function printBySemester(Request $request)
    {
        $semester   = $request->get('semester-p');
        $year       = $request->get('year-p');

        if ($semester == null || $year == null) {
            return redirect()->back()->with('status', 'Print gagal, Lakukan filtering Semester terlebih dahulu !');
        }

        if ($semester == "1") {
            $start_date  =  date('Y-m-d', strtotime($year . "-01-01"));
            $end_date    =  date('Y-m-d', strtotime($year . "-06-30"));
        } else {
            $start_date  =  date('Y-m-d', strtotime($year . "-07-01"));
            $end_date    =  date('Y-m-d', strtotime($year . "-12-31"));
        }

        $laporan = DB::table('laporan')
            ->Join('kegiatan', 'laporan.id_kegiatan', '=', 'kegiatan.id_kegiatan')
            ->Join('sekolah', 'laporan.id_sekolah', '=', 'sekolah.id_sekolah')
            ->Join('users', 'laporan.id_user', '=', 'users.id_user')
            ->Join('profiles', 'users.id_user', '=', 'profiles.id_user')
            ->select(
                'laporan.id_user',
                'laporan.id_kegiatan',
                'kegiatan.id_kegiatan',
                'kegiatan.kegiatan',
                'sekolah.nama_sekolah',
                'profiles.nama_lengkap',
                'profiles.logo_sekolah',
                'profiles.alamat_sekolah',
                'profiles.tambahan_informasi',
                'profiles.kelas_pengampu',
                DB::raw('COUNT(laporan.id_laporan) as jumlah_kegiatan'),
                DB::raw('SUM(ekuivalen) as jumlah_ekuivalen')
            )
            ->where('laporan.id_user', $request->get('id_user-p'))
            ->where('laporan.id_sekolah', $request->get('id_sekolah-p'))
            ->groupBy(
                'laporan.id_user',
                'laporan.id_kegiatan',
                'kegiatan.id_kegiatan',
                'kegiatan.kegiatan',
                'sekolah.nama_sekolah',
                'profiles.nama_lengkap',
                'profiles.logo_sekolah',
                'profiles.alamat_sekolah',
                'profiles.tambahan_informasi',
                'profiles.kelas_pengampu',
            )
            ->orderBy('laporan.id_laporan', 'desc');
        $laporan->whereYear('tgl_transaksi', $request->get('year-p'));
        $laporan->whereBetween('tgl_transaksi', [$start_date, $end_date]);
        $reports    = $laporan->get();
        $guru       = $laporan->first();

        if ($guru == null) {
            return abort(404, 'Maaf, data Tidak Ditemukan');
        }
        // return view('laporan.print.semesteran', compact('guru', 'reports', 'semester'));
        $namaLengkap = $guru->nama_lengkap;

        $pdf = PDF::loadView('laporan.print.semesteran', compact('guru', 'reports', 'semester'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('laporan-semesteran' . $namaLengkap . '.pdf');
    }

    public function printByYear(Request $request)
    {
        $year = $request->get('year-p');

        if ($year == null) {
            return redirect()->back()->with('status', 'Print gagal, Lakukan filtering Tahunan terlebih dahulu !');
        }

        $laporan = DB::table('laporan')
            ->Join('kegiatan', 'laporan.id_kegiatan', '=', 'kegiatan.id_kegiatan')
            ->Join('sekolah', 'laporan.id_sekolah', '=', 'sekolah.id_sekolah')
            ->Join('users', 'laporan.id_user', '=', 'users.id_user')
            ->Join('profiles', 'users.id_user', '=', 'profiles.id_user')
            ->select(
                'laporan.id_user',
                'laporan.id_kegiatan',
                'kegiatan.id_kegiatan',
                'kegiatan.kegiatan',
                'sekolah.nama_sekolah',
                'profiles.nama_lengkap',
                'profiles.logo_sekolah',
                'profiles.alamat_sekolah',
                'profiles.tambahan_informasi',
                'profiles.kelas_pengampu',
                DB::raw('COUNT(laporan.id_laporan) as jumlah_kegiatan'),
                DB::raw('SUM(ekuivalen) as jumlah_ekuivalen')
            )
            ->where('laporan.id_user', $request->get('id_user-p'))
            ->where('laporan.id_sekolah', $request->get('id_sekolah-p'))
            ->groupBy(
                'laporan.id_user',
                'laporan.id_kegiatan',
                'kegiatan.id_kegiatan',
                'kegiatan.kegiatan',
                'sekolah.nama_sekolah',
                'profiles.nama_lengkap',
                'profiles.logo_sekolah',
                'profiles.alamat_sekolah',
                'profiles.tambahan_informasi',
                'profiles.kelas_pengampu',
            )
            ->orderBy('laporan.id_laporan', 'desc');
        $laporan->whereYear('tgl_transaksi', $request->get('year-p'));
        $reports    = $laporan->get();
        $guru       = $laporan->first();

        if ($guru == null) {
            return abort(404, 'Maaf, data Tidak Ditemukan');
        }
        // return view('laporan.print.tahunan', compact('guru', 'reports', 'year'));
        $namaLengkap = $guru->nama_lengkap;

        $pdf = PDF::loadView('laporan.print.tahunan', compact('guru', 'reports', 'year'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('laporan-tahunan' . $namaLengkap . '.pdf');
    }

    public function printByTes(Request $request)
    {
        if ($request->get('tgl_transaksi-p') == null) {
            return redirect()->back()->with('status', 'Print gagal, Lakukan filtering harian terlebih dahulu !');
        }

        $laporan = Laporan::with(['sekolah', 'user.profile', 'kegiatan']);
        $laporan->where('id_user', $request->get('id_user-p'));
        $laporan->where('id_sekolah', $request->get('id_sekolah-p'));
        $laporan->where('tgl_transaksi', $request->get('tgl_transaksi-p'));

        $reports = $laporan->get();
        $guru = $laporan->first();
        // dd([$reports, $guru]);
        if ($guru == null) {
            return abort(404, 'Maaf, data Tidak Ditemukan');
        }

        // return view('laporan.print.tes', compact('guru', 'reports'));
        $namaLengkap = $guru->user->profile->nama_lengkap;

        $pdf = PDF::loadView('laporan.print.tes', compact('guru', 'reports'));
        $pdf->setPaper('A4', 'potrait');
        Storage::put('laporan/harian/' . 'LaporanHarian_' . $namaLengkap . '.pdf', $pdf->output());
        return $pdf->stream(('laporan/harian/') . 'LaporanHarian_' . $namaLengkap . '.pdf', compact($pdf));
        // return $pdf->download('laporan-harian_' . $namaLengkap . '.pdf');
        // $pdf->save(storage_path('laporan/harian/') . 'LaporanHarian_' . $namaLengkap . '.pdf');
        // return $pdf->stream(storage_path('laporan/harian/') . 'LaporanHarian_' . $namaLengkap . '.pdf', compact($pdf));
        // return $pdf->stream('laporan-tes_' . $namaLengkap . '.pdf', array('Attachment' => false));
    }
}
