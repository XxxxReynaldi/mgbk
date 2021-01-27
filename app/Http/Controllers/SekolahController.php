<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $schools = Sekolah::all();
        $schools = Sekolah::where('is_verified', 1)->get();
        return view('master_data.sekolah.index', compact('schools'));
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
        $request->validate([
            'nama_sekolah'      => 'required|max:255',
        ]);

        Sekolah::create([
            'nama_sekolah'  => $request->nama_sekolah,
            'is_verified'   => 1,
        ]);
        return redirect('/sekolah')->with('status', 'Data sekolah berhasil ditambahkan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function show(Sekolah $sekolah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function edit(Sekolah $sekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        $request->validate([
            'nama_sekolah'      => 'required|max:255',
        ]);

        Sekolah::where('id_sekolah', $sekolah->id_sekolah)
            ->update([
                'nama_sekolah'  => $request->nama_sekolah,
            ]);

        return redirect()->back()->with('status', 'Data sekolah berhasil diubah !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sekolah $sekolah)
    {
        Sekolah::destroy($sekolah->id_sekolah);
        return redirect()->back()->with('status', 'Data sekolah berhasil dihapus !');
    }

    /**
     * View index new school
     * 
     * @return \Illuminate\Http\Response
     */
    public function newSekolahIndex()
    {
        $schools = Sekolah::where('is_verified', 0)->get();
        return view('master_data.sekolah_baru.index', compact('schools'));
    }

    /**
     * Teacher store new School
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newSekolahStore(Request $request)
    {
        $request->validate([
            'nama_sekolah'      => 'required|max:255',
        ]);

        Sekolah::create([
            'nama_sekolah'  => $request->nama_sekolah,
            'is_verified'   => 0,
        ]);
        return redirect()->back()->with('status', 'Data sekolah berhasil ditambahkan !');
    }

    /**
     * Verified new school
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, Sekolah $sekolah)
    {
        $request->validate([
            'nama_sekolah'      => 'required|max:255',
        ]);

        Sekolah::where('id_sekolah', $sekolah->id_sekolah)
            ->update([
                'is_verified'  => 1,
            ]);

        return redirect()->back()->with('status', 'Verifikasi Sekolah berhasil!');
    }
}
