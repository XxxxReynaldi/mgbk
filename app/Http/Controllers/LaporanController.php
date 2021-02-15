<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Profile;
use App\Models\Sekolah;
use Illuminate\Http\Request;

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

    public function harian()
    {
        $schools = Sekolah::pluck('nama_sekolah', 'id_sekolah');

        return view('laporan.admin.harian', compact('schools'));
    }

    public function mingguan()
    {
        return view('laporan.admin.mingguan');
    }

    public function bulanan()
    {
        return view('laporan.admin.bulanan');
    }

    public function semesteran()
    {
        return view('laporan.admin.semesteran');
    }

    public function tahunan()
    {
        return view('laporan.admin.tahunan');
    }

    public function loadGuru(Request $request)
    {
        $guru = Profile::where('id_sekolah', $request->get('id_sekolah'))
            ->pluck('nama_lengkap', 'id_profile');

        return response()->json($guru);
    }
}