<?php

namespace App\Exports;
use App\Models\User;
use App\Models\Recibo;
use App\Models\Cliente;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Recibo::all();
    }
}
