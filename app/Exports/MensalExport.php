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

class MensalExport implements FromQuery
{
    use Exportable;

    public function forDate($date,$date2)
    {
        $this->date = $date;
        $this->date2 = $date2;
        
        return $this;
    }

    public function query()
    {
        return Recibo::query()->whereBetween('data',[$this->date,$this->date2])
        ->select(DB::raw("SUM(preco_total_sem_iva) as PrecoTotalSiva, SUM(iva) as iva, SUM(preco_total_com_iva) as PrecoTotalCiva, month(data)"))
        ->groupBy('month(data)')
        ->orderBy('month(data)','asc');
    }
}
