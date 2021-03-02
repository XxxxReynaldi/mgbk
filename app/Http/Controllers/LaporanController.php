<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Profile;
use App\Models\Sekolah;
use App\Models\Week;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function harian(Request $request)
    {
        $schools = Sekolah::pluck('nama_sekolah', 'id_sekolah');

        // if ($request->ajax()) {

        //     $laporan = Laporan::with(['user', 'sekolah', 'kegiatan'])
        //         ->where('id_sekolah', $request->id_sekolah)
        //         ->where('id_user', $request->id_user)
        //         ->where('tgl_transaksi', $request->tgl_transaksi);

        //     $dataTable = DataTables::eloquent($laporan)->make(true);
        // }

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

    public function semesteran()
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
                } else if ($request->has('laporan') && $request->get('laporan') == "tahunan") {
                    if ($request->has('year') && $request->get('year') != "") {
                        $query->whereYear('tgl_transaksi', $request->year);
                    }
                }
            })
            ->make(true);
        //
    }
}
