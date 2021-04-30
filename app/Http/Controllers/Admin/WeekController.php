<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\WeekImport;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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
        $weeks = $weeks->map(function ($week, $key) {
            $week->start_date   = date('d F Y', strtotime($week->start_date));
            $week->end_date     = date('d F Y', strtotime($week->end_date));
            return $week;
        });
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
        $this->validate($request, [
            'file_excel_week'       => 'required|file|mimes:xls,xlsx|max:2048',
        ]);
        $file       = $request->file('file_excel_week');
        $namaFile   = $file->getClientOriginalName();

        Excel::import(new WeekImport, $file);
        // Storage::makeDirectory('public/dokumenWeek/' . $namaFile);

        return redirect('/admin/week')->with('status', 'Data week berhasil diimport !');
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
            'week'       => 'required|max:255',
            'year'       => 'required|max:9',
            'start_date' => 'required',
            'end_date'   => 'required',
        ]);
        Week::create($request->all());
        return redirect('/admin/week')->with('status', 'Data week berhasil ditambahkan !');
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
        $request->validate([
            'week'       => 'required|max:255',
            'year'       => 'required|max:9',
            'start_date' => 'required',
            'end_date'   => 'required',
        ]);
        Week::where('id_week', $week->id_week)
            ->update([
                'week'          => $request->week,
                'year'          => $request->year,
                'start_date'    => $request->start_date,
                'end_date'      => $request->end_date,
            ]);

        return redirect('/admin/week')->with('status', 'Data week berhasil diubah !');
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
        return redirect('/admin/week')->with('status', 'Data week berhasil dihapus !');
    }

    public function downloadMWeek()
    {
        return Storage::download('MasterWeekFormat.xlsx');
    }
}
