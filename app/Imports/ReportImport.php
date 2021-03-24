<?php

namespace App\Imports;

use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ReportImport implements
    ToModel,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts
{

    /**
     * Transform a date value into a Carbon object.
     *
     * @return \Carbon\Carbon|null
     */
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $id_kegiatan_cek    = $this->checkActivity($row['kegiatan']);
        $tgl_transaksi      = date('Y-m-d', strtotime($this->transformDate($row['tgl_transaksi'])));

        $kosong = null;
        if ($id_kegiatan_cek == null) {
            return $kosong;
        } else {

            return new Laporan([
                'id_sekolah'        => $row['id_sekolah'],
                'id_user'           => $row['id_user'],
                'id_kegiatan'       => $id_kegiatan_cek->id_kegiatan,
                'tgl_transaksi'     => $tgl_transaksi,
                'detail'            => $row['detail'],
            ]);
        }
    }

    /**
     * @param array $activity_name
     *
     * @return $id_kegiatan
     */
    public function checkActivity($activity_name)
    {
        $id_kegiatan = DB::table('kegiatan')
            ->select('id_kegiatan')
            ->where('kegiatan', '=', $activity_name)
            ->first();

        return $id_kegiatan;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
