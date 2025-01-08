<?php

namespace App\Imports;

use App\Models\Marketing;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportMarketing implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Marketing([
            'sumber_marketing_id' => $row['sumber_marketing_id'],
            'nama' => $row['nama'] ?? '',
            'maps' => $row['maps'] ?? NULL,
            'rating' => $row['rating'] ?? NULL,
            'alamat' => $row['alamat'] ?? '',
            'no_hp' => $row['no_hp'],
            'brand' => $row['brand'] ?? NULL,
            'label' => $row['label'],
            'tanggal' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])),
            'status_prospek' => $row['status_prospek'],
        ]);
    }
}
