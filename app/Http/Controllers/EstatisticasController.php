<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Recibo;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB; // para poder usar o DB:..........
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use App\Exports\ExcelExport;
use Maatwebsite\Excel\Facades\Excel;


class EstatisticasController extends Controller
{
  public function estatisticas_totais_diario(Request $request)
    {
      //dd($request);
      $dataPedida = $request->datainicio.'-01';
      if ($request->datainicio == null) {
        $dataInicio = Carbon::now()
                        ->firstOfMonth()
                        ->format('Y-m-d');
        $dataFim = Carbon::now()
                        ->lastOfMonth()
                        ->format('Y-m-d');
        $dataSelecionada = 0;
      }else{
        $dataInicio = Carbon::createFromFormat('Y-m-d', $dataPedida)
                        ->firstOfMonth()
                        ->format('Y-m-d');
        $dataFim = Carbon::createFromFormat('Y-m-d', $dataPedida)
                        ->lastOfMonth()
                        ->format('Y-m-d');
        $dataSelecionada = $request->datainicio;
      }
      $totaisDiarios = Recibo::where('data','>=',$dataInicio)
                          ->where('data','<=',$dataFim)
                          ->select(DB::raw("SUM(preco_total_sem_iva) as PrecoTotalSiva, SUM(iva) as iva, SUM(preco_total_com_iva) as PrecoTotalCiva, data"))
                          ->groupBy('data')
                          ->get();   
                          //dd($totaisDiarios);  

      return view('estatisticas.totais.diarios')
              ->with('dataSelecionada', $dataSelecionada)
              ->with('totaisDiarios', $totaisDiarios);
    }

  public function estatisticas_total_mensal(Request $request)
    { 
      if ($request->ano) {
        $anoPedido = $request->ano;
        $dataInicio = Carbon::createFromFormat('Y', $anoPedido)
                        ->firstOfYear()
                        ->format('Y-m-d');
        $dataFim = Carbon::createFromFormat('Y', $anoPedido)
                        ->lastOfYear()
                        ->format('Y-m-d');

        $totaisMensal = Recibo::where('data','>=',$dataInicio)
                          ->where('data','<=',$dataFim)
                          ->select(DB::raw("SUM(preco_total_sem_iva) as PrecoTotalSiva, SUM(iva) as iva, SUM(preco_total_com_iva) as PrecoTotalCiva, month(data)"))
                          ->groupBy('month(data)')
                          ->get();
      }else{
        $dataInicio = Carbon::now()
                        ->firstOfYear()
                        ->format('Y-m-d');
        $dataFim = Carbon::now()
                        ->lastOfYear()
                        ->format('Y-m-d');
        $anoPedido = 2022;
        $totaisMensal = Recibo::where('data','>=',$dataInicio)
                          ->where('data','<=',$dataFim)
                          ->select(DB::raw("SUM(preco_total_sem_iva) as PrecoTotalSiva, SUM(iva) as iva, SUM(preco_total_com_iva) as PrecoTotalCiva, month(data)"))
                          ->groupBy('month(data)')
                          ->get();
      }    
      //dd($totaisMensal);          
      return view('estatisticas.totais.mensal')
              ->with('anoPedido', $anoPedido)
              ->with('totaisMensal', $totaisMensal);
    }
    public function estatisticas_total_anual(Request $request)
    { 
      $totaisAnual = Recibo::select(DB::raw("SUM(preco_total_sem_iva) as PrecoTotalSiva, SUM(iva) as iva, SUM(preco_total_com_iva) as PrecoTotalCiva, year(data)"))
                          ->groupBy('year(data)')
                          ->get();
      //dd($totaisAnual);          
      return view('estatisticas.totais.anual')
              ->with('totaisAnual', $totaisAnual);
    }

    public function export() 
    {
        return Excel::download(new EstatisticasController, 'excel.xlsx');
    }

}
