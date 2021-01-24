<?php

namespace App\Imports;

use App\Week;
use Maatwebsite\Excel\Concerns\ToModel;

class WeekImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Week([
            'week'          => $row[0],
            'year'          => $row[1],
            'start_date'    => $row[2],
            'end_date'      => $row[3],

        ]);
    }
}
