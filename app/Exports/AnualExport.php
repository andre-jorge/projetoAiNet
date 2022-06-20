<?php

namespace App\Exports;
use App\Models\User;
use App\Models\Recibo;
use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AnualExport implements FromQuery
{
    use Exportable;

    public function query()
    {
        return Recibo::select(DB::raw("SUM(preco_total_sem_iva) as PrecoTotalSiva, SUM(iva) as iva, SUM(preco_total_com_iva) as PrecoTotalCiva, year(data)"))
        ->groupBy('year(data)')
        ->orderBy('year(data)','asc');
    }
}
