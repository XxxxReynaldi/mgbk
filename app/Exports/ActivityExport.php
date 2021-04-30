<?php

namespace App\Exports;

use App\Models\Kegiatan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ActivityExport implements FromView
{
    public function view(): View
    {
        $kegiatan   = Kegiatan::all();
        return view('master_data.kegiatan.excel-export', compact('kegiatan'));
    }
}
