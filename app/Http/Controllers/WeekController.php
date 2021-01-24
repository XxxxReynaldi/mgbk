<?php

namespace App\Http\Controllers;

use App\Imports\WeekImport;
use App\Models\Week;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class WeekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weeks = Week::all();
        return view('master_data.week.index', compact('weeks'));
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

    public function import(Request $request)
    {
        $file       = $request->file('file_excel');
        $namaFile   = $file->getClientOriginalName();
        $file->move('DataWeeks', $namaFile);

        Excel::import(new WeekImport, public_path('/DataWeeks/' . $namaFile));
        return redirect('/week')->with('status', 'Data sekolah berhasil diimport !');
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
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function show(Week $week)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function edit(Week $week)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Week $week)
    {
        Week::where('id_week', $week->id_week)
            ->update([
                'week'          => $request->week,
                'year'          => $request->year,
                'start_date'    => $request->start_date,
                'end_date'      => $request->end_date,
            ]);

        return redirect('/week')->with('status', 'Data week berhasil diubah !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function destroy(Week $week)
    {
        Week::destroy($week->id_week);
        return redirect('/week')->with('status', 'Data week berhasil dihapus !');
    }
}
