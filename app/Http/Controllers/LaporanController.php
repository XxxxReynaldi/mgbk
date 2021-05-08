<?php

namespace App\Http\Controllers;

use App\Exports\ActivityExport;
use App\Imports\ReportImport;
use App\Models\Kegiatan;
use App\Models\Laporan;
use App\Models\Profile;
use App\Models\Sekolah;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
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
        $id_user    = Auth::user()->id_user;

        // $statImport = Excel::import(new ReportImport, $file);
        // dump($statImport);

        Excel::import(new ReportImport($id_user), $file);
        // Storage::makeDirectory('public/dokumenReport/' . $namaFile);

        return redirect()->back()->with('status', 'Data Laporan berhasil diimport !');
    }

    public function exportActivity()
    {
        $namaFile = 'laporan' . date('Y-m-d H:i:s') . '.xlsx';
        return Excel::download(new ActivityExport, $namaFile);
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
            ->addColumn('doc_2', function ($reports) {
                return $reports->upload_doc_2;
            })
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

    private function tgl_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }

    private function bln_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $bulan[(int)$pecahkan[1]];
    }

    private function setHeaderFooter($mpdf, $guru, $table, $printBy, $reportTime = null, $withHeader)
    {

        $printTime  = $this->tgl_indo(date("Y-m-d"));

        if ($printBy == 'date') {
            $reportFor  = 'Tanggal laporan';
            $reportTime = $this->tgl_indo($guru->tgl_transaksi);
        } elseif ($printBy == 'week') {
            $reportFor  = 'Minggu ke';
            $reportTime = $reportTime->week;
        } elseif ($printBy == 'month') {
            $reportFor  = 'Bulan ke';
            $reportTime = $this->bln_indo($guru->tgl_transaksi);
        } elseif ($printBy == 'semester') {
            $reportFor  = 'Semester ke';
            $reportTime = $reportTime;
        } elseif ($printBy == 'year') {
            $reportFor  = 'Tahun ke';
            $reportTime = $reportTime;
        }

        $stylesheet = file_get_contents(public_path('css/mpdf.css'));
        $mpdf->WriteHTML($stylesheet, 1);
        if ($withHeader == 1) {
            // dengan header
            $mpdf->SetHTMLHeader('
            <table class="border w-100 p-max mb-max valign-middle">
                <tr>
                    <th>
                        <img src="https://api-mgbk.bgskr-project.my.id/upload/logoSekolah/' . $guru->logo_sekolah . '" width="80" height="80">
                    </th>
                    <th>
                        <span class="text-title">' . $guru->nama_sekolah . ' </span><br>
                        <span class="text-regular">' . $guru->alamat_sekolah . '</span><br>
                        <span class="text-regular">' . $guru->tambahan_informasi . '</span><br>
                    </th>
                </tr>
            </table>

            <table class="mb-max">
                <tr>
                    <th class="text-align-left" style="width:30%;">
                        Nama Guru
                    </th>
                    <td>
                        :  ' . $guru->nama_lengkap . '
                    </td>
                </tr>
                <tr>
                    <th class="text-align-left" style="width:30%;">
                        Kelas yang diampuh
                    </th>
                    <td>
                        : 
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> 
                        ' . $table . '
                    </td>
                </tr>
                <tr>
                    <th class="text-align-left" style="width:30%;">
                        ' . $reportFor . '
                    </th>
                    <td>
                        : ' . $reportTime . '
                    </td>
                </tr>
                <tr>
                    <th class="text-align-left" style="width:30%;">
                        Tanggal cetak laporan
                    </th>
                    <td>
                        : ' . $printTime . '
                    </td>
                </tr>
            </table>

            <p>
                Berikut detail laporan dari Guru BK yang bersangkutan :
            </p>');
        } else {
            // tanpa header
            $mpdf->SetHTMLHeader('
            <table class="mb-max">
                <tr>
                    <th class="text-align-left" style="width:30%;">
                        Nama Guru
                    </th>
                    <td>
                        :  ' . $guru->nama_lengkap . '
                    </td>
                </tr>
                <tr>
                    <th class="text-align-left" style="width:30%;">
                        Kelas yang diampuh
                    </th>
                    <td>
                        : 
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> 
                        ' . $table . '
                    </td>
                </tr>
                <tr>
                    <th class="text-align-left" style="width:30%;">
                        ' . $reportFor . '
                    </th>
                    <td>
                        : ' . $reportTime . '
                    </td>
                </tr>
                <tr>
                    <th class="text-align-left" style="width:30%;">
                        Tanggal cetak laporan
                    </th>
                    <td>
                        : ' . $printTime . '
                    </td>
                </tr>
            </table>

            <p>
                Berikut detail laporan dari Guru BK yang bersangkutan :
            </p>');
        }
        $mpdf->SetHTMLFooter('
        <table class="table-layout-fixed w-100">
            <tr>
                <td style="width:50%;">
                <table class="border-1 border-collapse table-layout-fixed" style="width: 400px;">
                    <tr>
                        <th class="border-1 p-min w-50">Mengetahui</th>
                    </tr>
                    <tr class="text-align-center">
                        <td class="border-1 p-min"><img style="visibility: hidden;" src="https://via.placeholder.com/100" width="100px" height="100px" /></td>
                    </tr>
                    <tr>
                        <td class="border-1 p-min text-align-center">' . $guru->nama_kepala_sekolah . '</td>
                    </tr>
                    <tr>
                        <td class="border-1 p-min text-align-center">Kepala Sekolah</td>
                    </tr>
                </table>
                </td>
                <td style="width:50%">
                <table class="border-1 border-collapse table-layout-fixed" style="width: 400px;">
                    <tr>
                        <th class="border-1 p-min w-50">Dibuat</th>
                    </tr>
                    <tr class="text-align-center">
                        <td class="border-1 p-min"><img style="visibility: hidden;" src="https://via.placeholder.com/100" width="100px" height="100px" /></td>
                    </tr>
                    <tr>
                        <td class="border-1 p-min text-align-center">' . $guru->nama_lengkap . '</td>
                    </tr>
                    <tr>
                        <td class="border-1 p-min text-align-center">Guru BK</td>
                    </tr>
                </table>
                </td>
            </tr>
        </table>
        ');
    }

    public function printByDate(Request $request)
    {
        if ($request->get('tgl_transaksi-p') == null) {
            return redirect()->back()->with('status', 'Print gagal, Lakukan filtering harian terlebih dahulu !');
        }

        $withHeader = $request->has('with_header') ? 1 : 0;

        // $laporan = Laporan::with(['sekolah', 'user.profile', 'kegiatan']);
        // $laporan->where('id_user', $request->get('id_user-p'));
        // $laporan->where('id_sekolah', $request->get('id_sekolah-p'));

        $laporan = DB::table('laporan')
            ->Join('kegiatan', 'laporan.id_kegiatan', '=', 'kegiatan.id_kegiatan')
            ->Join('sekolah', 'laporan.id_sekolah', '=', 'sekolah.id_sekolah')
            ->Join('users', 'laporan.id_user', '=', 'users.id_user')
            ->Join('profiles', 'users.id_user', '=', 'profiles.id_user')
            ->select(
                'laporan.id_user',
                'laporan.id_kegiatan',
                'laporan.tgl_transaksi',
                'laporan.detail',
                'kegiatan.id_kegiatan',
                'kegiatan.kegiatan',
                'sekolah.nama_sekolah',
                'profiles.nama_lengkap',
                'profiles.logo_sekolah',
                'profiles.alamat_sekolah',
                'profiles.nama_kepala_sekolah',
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
                'laporan.tgl_transaksi',
                'laporan.detail',
                'kegiatan.id_kegiatan',
                'kegiatan.kegiatan',
                'sekolah.nama_sekolah',
                'profiles.nama_lengkap',
                'profiles.logo_sekolah',
                'profiles.alamat_sekolah',
                'profiles.nama_kepala_sekolah',
                'profiles.tambahan_informasi',
                'profiles.kelas_pengampu',
            )
            ->orderBy('laporan.id_laporan', 'ASC');
        $laporan->where('tgl_transaksi', $request->get('tgl_transaksi-p'));

        $reports = $laporan->get();
        $guru = $laporan->first();
        // dd([$reports, $guru]);
        if ($guru == null) {
            return abort(404, 'Maaf, data Tidak Ditemukan');
        }

        // return view('laporan.print.harian', compact('guru', 'reports'));
        // $namaLengkap = $guru->user->profile->nama_lengkap;
        $namaLengkap = $guru->nama_lengkap;

        // $kelas       = $guru->user->profile->kelas_pengampu;
        $kelas      = $guru->kelas_pengampu;
        $eachkelas  = explode(";", $kelas);

        $table = '<table style="width: 50%;"><tr>';
        $td = '<td style="width:50%;">';
        $ul = '<ul>';
        $no = 0;
        $marginTop = 95;
        $marginBot = 45;

        foreach ($eachkelas as $item) :
            $marginTop = $marginTop + 5;
            $marginBot = $marginBot + 5;

            if ($no == ($no % 4 == 0)) {
                $ul .= '</ul></td>';

                $ul .= $td . '<ul>';
                $marginTop = 90;
                $marginBot = 50;
            }
            $ul .= '<li>' . $item . '</li>';

            $no++;
            if ($no > 4) {
                $marginTop = 105;
                $marginBot = 65;
            }
        endforeach;

        $ul .= '</ul>';
        $td .= $ul . '</td>';
        $table .= $td . '</tr></table>';

        $mpdf = new \Mpdf\Mpdf();

        $filename   = 'laporan-harian' . $namaLengkap . '.pdf';
        $mpdf       = new \Mpdf\Mpdf([
            'margin_left'   => 10,
            'margin_right'  => 10,
            'margin_top'    => $marginTop,
            'margin_bottom' => $marginBot,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        $html   = View::make('laporan.print.harian')->with('reports', $reports);
        $html   = $html->render();

        $this->setHeaderFooter($mpdf, $guru, $table, 'date', null, $withHeader);

        $mpdf->autoPageBreak = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, 'I');
    }

    public function printByWeek(Request $request)
    {
        if ($request->get('id_week-p') == null) {
            return redirect()->back()->with('status', 'Print gagal, Lakukan filtering mingguan terlebih dahulu !');
        }
        $withHeader = $request->has('with_header') ? 1 : 0;
        $week = DB::table('weeks')
            ->where('id_week', $request->get('id_week-p'))
            ->first();
        $tgl_awal  = date('Y-m-d', strtotime($week->start_date));
        $tgl_akhir = date('Y-m-d', strtotime($week->end_date));

        // $laporan = Laporan::with(['sekolah', 'user.profile', 'kegiatan']);
        // $laporan->where('id_user', $request->get('id_user-p'));
        // $laporan->where('id_sekolah', $request->get('id_sekolah-p'));
        // $laporan->whereBetween('tgl_transaksi', [$tgl_awal, $tgl_akhir]);

        // $reports = $laporan->get();
        // $guru = $laporan->first();

        $laporan = DB::table('laporan')
            ->Join('kegiatan', 'laporan.id_kegiatan', '=', 'kegiatan.id_kegiatan')
            ->Join('sekolah', 'laporan.id_sekolah', '=', 'sekolah.id_sekolah')
            ->Join('users', 'laporan.id_user', '=', 'users.id_user')
            ->Join('profiles', 'users.id_user', '=', 'profiles.id_user')
            ->select(
                'laporan.id_user',
                'laporan.id_kegiatan',
                'laporan.tgl_transaksi',
                'laporan.detail',
                'kegiatan.id_kegiatan',
                'kegiatan.kegiatan',
                'sekolah.nama_sekolah',
                'profiles.nama_lengkap',
                'profiles.logo_sekolah',
                'profiles.alamat_sekolah',
                'profiles.nama_kepala_sekolah',
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
                'laporan.tgl_transaksi',
                'laporan.detail',
                'kegiatan.id_kegiatan',
                'kegiatan.kegiatan',
                'sekolah.nama_sekolah',
                'profiles.nama_lengkap',
                'profiles.logo_sekolah',
                'profiles.alamat_sekolah',
                'profiles.nama_kepala_sekolah',
                'profiles.tambahan_informasi',
                'profiles.kelas_pengampu',
            )
            ->orderBy('laporan.id_laporan', 'ASC');
        $laporan->whereBetween('tgl_transaksi', [$tgl_awal, $tgl_akhir]);

        $reports = $laporan->get();
        $guru = $laporan->first();
        // dd([$reports, $guru]);
        if ($guru == null) {
            return abort(404, 'Maaf, data Tidak Ditemukan');
        }

        // $namaLengkap = $guru->user->profile->nama_lengkap;
        $namaLengkap = $guru->nama_lengkap;

        // $kelas       = $guru->user->profile->kelas_pengampu;
        $kelas      = $guru->kelas_pengampu;
        $eachkelas  = explode(";", $kelas);

        $table = '<table style="width: 50%;"><tr>';
        $td = '<td style="width:50%;">';
        $ul = '<ul>';
        $no = 0;
        $marginTop = 95;
        $marginBot = 45;

        foreach ($eachkelas as $item) :
            $marginTop = $marginTop + 5;
            $marginBot = $marginBot + 5;

            if ($no == ($no % 4 == 0)) {
                $ul .= '</ul></td>';

                $ul .= $td . '<ul>';
                $marginTop = 90;
                $marginBot = 50;
            }
            $ul .= '<li>' . $item . '</li>';

            $no++;
            if ($no > 4) {
                $marginTop = 105;
                $marginBot = 65;
            }
        endforeach;

        $ul .= '</ul>';
        $td .= $ul . '</td>';
        $table .= $td . '</tr></table>';

        $mpdf = new \Mpdf\Mpdf();

        $filename   = 'laporan-mingguan' . $namaLengkap . '.pdf';
        $mpdf       = new \Mpdf\Mpdf([
            'margin_left'   => 10,
            'margin_right'  => 10,
            'margin_top'    => $marginTop,
            'margin_bottom' => $marginBot,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        $html   = View::make('laporan.print.mingguan')->with('reports', $reports);
        $html   = $html->render();

        $this->setHeaderFooter($mpdf, $guru, $table, 'week', $week, $withHeader);

        $mpdf->autoPageBreak = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, 'I');
    }

    public function printByMonth(Request $request)
    {
        $year       = $request->get('year-p');
        $month      = $request->get('month-p');
        $id_user    = $request->get('id_user-p');
        $id_sekolah = $request->get('id_sekolah-p');
        $withHeader = $request->has('with_header') ? 1 : 0;

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
                'profiles.nama_kepala_sekolah',
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
                'profiles.nama_kepala_sekolah',
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

        $kelas      = $guru->kelas_pengampu;
        $eachkelas  = explode(";", $kelas);

        $table = '<table style="width: 50%;"><tr>';
        $td = '<td style="width:50%;">';
        $ul = '<ul>';
        $no = 0;
        $marginTop = 95;
        $marginBot = 45;

        foreach ($eachkelas as $item) :
            $marginTop = $marginTop + 5;
            $marginBot = $marginBot + 5;

            if ($no == ($no % 4 == 0)) {
                $ul .= '</ul></td>';

                $ul .= $td . '<ul>';
                $marginTop = 90;
                $marginBot = 50;
            }
            $ul .= '<li>' . $item . '</li>';

            $no++;
            if ($no > 4) {
                $marginTop = 105;
                $marginBot = 65;
            }
        endforeach;

        $ul .= '</ul>';
        $td .= $ul . '</td>';
        $table .= $td . '</tr></table>';

        $mpdf = new \Mpdf\Mpdf();

        $filename   = 'laporan-bulanan' . $namaLengkap . '.pdf';
        $mpdf       = new \Mpdf\Mpdf([
            'margin_left'   => 10,
            'margin_right'  => 10,
            'margin_top'    => $marginTop,
            'margin_bottom' => $marginBot,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        $html   = View::make('laporan.print.bulanan')->with('reports', $reports);
        $html   = $html->render();

        $this->setHeaderFooter($mpdf, $guru, $table, 'month', $month, $withHeader);

        $mpdf->autoPageBreak = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, 'I');
    }

    public function printBySemester(Request $request)
    {
        $semester   = $request->get('semester-p');
        $year       = $request->get('year-p');
        $withHeader = $request->has('with_header') ? 1 : 0;

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
                'profiles.nama_kepala_sekolah',
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
                'profiles.nama_kepala_sekolah',
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

        $kelas      = $guru->kelas_pengampu;
        $eachkelas  = explode(";", $kelas);

        $table = '<table style="width: 50%;"><tr>';
        $td = '<td style="width:50%;">';
        $ul = '<ul>';
        $no = 0;
        $marginTop = 95;
        $marginBot = 45;

        foreach ($eachkelas as $item) :
            $marginTop = $marginTop + 5;
            $marginBot = $marginBot + 5;

            if ($no == ($no % 4 == 0)) {
                $ul .= '</ul></td>';

                $ul .= $td . '<ul>';
                $marginTop = 90;
                $marginBot = 50;
            }
            $ul .= '<li>' . $item . '</li>';

            $no++;
            if ($no > 4) {
                $marginTop = 105;
                $marginBot = 65;
            }
        endforeach;

        $ul .= '</ul>';
        $td .= $ul . '</td>';
        $table .= $td . '</tr></table>';

        $mpdf = new \Mpdf\Mpdf();

        $filename   = 'laporan-semesteran' . $namaLengkap . '.pdf';
        $mpdf       = new \Mpdf\Mpdf([
            'margin_left'   => 10,
            'margin_right'  => 10,
            'margin_top'    => $marginTop,
            'margin_bottom' => $marginBot,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        $html   = View::make('laporan.print.semesteran')->with('reports', $reports);
        $html   = $html->render();

        $this->setHeaderFooter($mpdf, $guru, $table, 'semester', $semester, $withHeader);

        $mpdf->autoPageBreak = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, 'I');
    }

    public function printByYear(Request $request)
    {
        $year       = $request->get('year-p');
        $withHeader = $request->has('with_header') ? 1 : 0;

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
                'profiles.nama_kepala_sekolah',
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
                'profiles.nama_kepala_sekolah',
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

        $kelas      = $guru->kelas_pengampu;
        $eachkelas  = explode(";", $kelas);

        $table = '<table style="width: 50%;"><tr>';
        $td = '<td style="width:50%;">';
        $ul = '<ul>';
        $no = 0;
        $marginTop = 95;
        $marginBot = 45;

        foreach ($eachkelas as $item) :
            $marginTop = $marginTop + 5;
            $marginBot = $marginBot + 5;

            if ($no == ($no % 4 == 0)) {
                $ul .= '</ul></td>';

                $ul .= $td . '<ul>';
                $marginTop = 90;
                $marginBot = 50;
            }
            $ul .= '<li>' . $item . '</li>';

            $no++;
            if ($no > 4) {
                $marginTop = 105;
                $marginBot = 65;
            }
        endforeach;

        $ul .= '</ul>';
        $td .= $ul . '</td>';
        $table .= $td . '</tr></table>';

        $mpdf = new \Mpdf\Mpdf();

        $filename   = 'laporan-tahunan' . $namaLengkap . '.pdf';
        $mpdf       = new \Mpdf\Mpdf([
            'margin_left'   => 10,
            'margin_right'  => 10,
            'margin_top'    => $marginTop,
            'margin_bottom' => $marginBot,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        $html   = View::make('laporan.print.tahunan')->with('reports', $reports);
        $html   = $html->render();

        $this->setHeaderFooter($mpdf, $guru, $table, 'year', $year, $withHeader);

        $mpdf->autoPageBreak = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, 'I');
    }
}
