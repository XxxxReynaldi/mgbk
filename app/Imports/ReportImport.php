<?php

namespace App\Imports;

use App\Models\Laporan;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class ReportImport implements
    ToModel,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts,
    WithValidation
{

    public function  __construct($user_id)
    {
        $this->user_id = $user_id;
    }

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

        $profile            = Profile::with('user', 'sekolah')->where('id_user', $this->user_id)->first();

        $kosong = null;
        if ($id_kegiatan_cek == null) {
            return $kosong;
        } else {

            return new Laporan([
                'id_sekolah'        => $profile->id_sekolah,
                'id_user'           => $this->user_id,
                'id_kegiatan'       => $id_kegiatan_cek->id_kegiatan,
                'tgl_transaksi'     => $tgl_transaksi,
                'detail'            => $row['detail'],
                'upload_doc_2'      => $row['doc_2'],
            ]);
        }
    }

    /**
     * @param array $activity_name
     *
     * @return $id_kegiatan
     */
    public function checkActivity($activity_name = null)
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

    public function rules(): array
    {
        $kegiatan = DB::table('kegiatan')->select('kegiatan')->get();
        $activity = [];
        foreach ($kegiatan as $key => $value) {
            array_push($activity, $value->kegiatan);
        }

        return [
            'kegiatan' => Rule::in($activity),
            // Above is alias for as it always validates in batches
            '*.kegiatan' => Rule::in($activity),
        ];

        // https://laracasts.com/discuss/channels/laravel/getting-validation-errors-from-laravel-excel
        // https://github.com/Maatwebsite/Laravel-Excel/issues/2111
    }
}
