<?php

namespace App\Imports;

use App\Models\Week as Week;
use Carbon\Carbon;
// use App\Week;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class WeekImport implements
    ToModel,
    // ToCollection,
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

        $tglawal    = date('Y-m-d', strtotime($this->transformDate($row['startdate'])));
        $tglakhir   = date('Y-m-d', strtotime($this->transformDate($row['enddate'])));

        return new Week([
            'week'          => $row['week'],
            'year'          => $row['year'],
            'start_date'    => $tglawal,
            'end_date'      => $tglakhir,
        ]);
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
