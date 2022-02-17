<?php

namespace App\Exports;

use App\Models\CnModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class CnExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CnModel::all();
    }
}
