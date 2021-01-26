<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\SekolahBaru;
use Illuminate\Http\Request;

class SekolahBaruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = SekolahBaru::all();
        return view('master_data.sekolah_baru.index', compact('schools'));
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

        SekolahBaru::create($request->all());
        return redirect('/sekolah_baru')->with('status', 'Data sekolah baru berhasil ditambahkan !');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, SekolahBaru $sekolahBaru)
    {
        $request->validate([
            'nama_sekolah'      => 'required|max:255',
        ]);

        Sekolah::create($request->all());
        SekolahBaru::destroy($sekolahBaru->id_sekolah_baru);

        return redirect('/sekolah_baru')->with('status', 'Verifikasi Sekolah berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SekolahBaru  $sekolahBaru
     * @return \Illuminate\Http\Response
     */
    public function show(SekolahBaru $sekolahBaru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SekolahBaru  $sekolahBaru
     * @return \Illuminate\Http\Response
     */
    public function edit(SekolahBaru $sekolahBaru)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SekolahBaru  $sekolahBaru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SekolahBaru $sekolahBaru)
    {
        $request->validate([
            'nama_sekolah'      => 'required|max:255',
        ]);

        SekolahBaru::where('id_sekolah_baru', $sekolahBaru->id_sekolah_baru)
            ->update([
                'nama_sekolah'  => $request->nama_sekolah,
            ]);

        return redirect('/sekolah_baru')->with('status', 'Data sekolah baru berhasil diubah !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SekolahBaru  $sekolahBaru
     * @return \Illuminate\Http\Response
     */
    public function destroy(SekolahBaru $sekolahBaru)
    {
        SekolahBaru::destroy($sekolahBaru->id_sekolah_baru);
        return redirect('/sekolah_baru')->with('status', 'Data sekolah baru berhasil dihapus !');
    }
}
