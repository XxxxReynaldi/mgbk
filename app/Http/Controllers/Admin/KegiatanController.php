<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Kegiatan::all();
        return view('master_data.kegiatan.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master_data.kegiatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Kegiatan::create($request->all());
        return redirect('/admin/kegiatan')->with('status', 'Data kegiatan berhasil ditambahkan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function show(Kegiatan $kegiatan)
    {
        return view('master_data.kegiatan.show', compact('kegiatan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kegiatan $kegiatan)
    {
        return view('master_data.kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        Kegiatan::where('id_kegiatan', $kegiatan->id_kegiatan)
            ->update([
                'sasaran_kegiatan'  => $request->sasaran_kegiatan,
                'kegiatan'          => $request->kegiatan,
                'satuan_kegiatan'   => $request->satuan_kegiatan,
                'uraian'            => $request->uraian,
                'pelaporan'         => $request->pelaporan,
                'durasi'            => $request->durasi,
                'satuan_waktu'      => $request->satuan_waktu,
                'jumlah_pertemuan'  => $request->jumlah_pertemuan,
                'ekuivalen'         => $request->ekuivalen,
            ]);

        return redirect('/admin/kegiatan')->with('status', 'Data kegiatan berhasil diubah !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kegiatan $kegiatan)
    {
        Kegiatan::destroy($kegiatan->id_kegiatan);
        return redirect('/admin/kegiatan')->with('status', 'Data kegiatan berhasil dihapus !');
    }
}
