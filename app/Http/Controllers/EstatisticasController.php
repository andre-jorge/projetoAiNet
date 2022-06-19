<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Filme;
use App\Models\Sessao;
use App\Models\Bilhetes;
use App\Models\Lugares;
use App\Models\Salas;
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


    public function estatisticas_bilhetes_filmes(Request $request)
    { 
      $filmes = Filme::paginate(8);
      //dd($filmes);        
      if ($request->string) {
        $filmes = Filme::where('titulo', 'like', '%' . $request->string . '%')
                           ->paginate(8);
      }  
      return view('estatisticas.bilhetes.filmes')
              ->with('filmes', $filmes);
    }

    public function estatisticas_bilhetes_filmes_sessoes(Request $request, Filme $filme)
    { 
      $sessoesFilme =DB::select('SELECT ses.*,(
      SELECT COUNT(*) FROM bilhetes bil
      WHERE bil.sessao_id = ses.id
      ) AS "BilhetesVendidos", 
      (
      SELECT COUNT(*) FROM bilhetes bil
      WHERE bil.sessao_id = ses.id
      AND bil.estado = "usado"
      ) AS "Usados",
      (
      SELECT COUNT(*) FROM bilhetes bil
      WHERE bil.sessao_id = ses.id
      AND bil.estado = "não usado"
      ) AS "Naousados",
      (
      SELECT COUNT(*)
      FROM lugares lug
      WHERE lug.sala_id = ses.sala_id
      ) AS "Totallugares",
      round(
      (SELECT COUNT(*) FROM bilhetes bil
      WHERE bil.sessao_id = ses.id)*100/
      (SELECT COUNT(*)
      FROM lugares lug
      WHERE lug.sala_id = ses.sala_id),2
      )AS "TaxaOcupação" 
        
      FROM sessoes ses
      LEFT JOIN filmes fil
      ON ses.filme_id=fil.id
      WHERE fil.id = '. $filme->id . '');
      //dd($sessoesFilme);
        //dd($request->ordenar);
        
        if ($request->ordenar == 1 ) {
          $sessoesFilme =DB::select('SELECT ses.*,(
            SELECT COUNT(*) FROM bilhetes bil
            WHERE bil.sessao_id = ses.id
            ) AS "BilhetesVendidos", 
            (
            SELECT COUNT(*) FROM bilhetes bil
            WHERE bil.sessao_id = ses.id
            AND bil.estado = "usado"
            ) AS "Usados",
            (
            SELECT COUNT(*) FROM bilhetes bil
            WHERE bil.sessao_id = ses.id
            AND bil.estado = "não usado"
            ) AS "Naousados",
            (
            SELECT COUNT(*)
            FROM lugares lug
            WHERE lug.sala_id = ses.sala_id
            ) AS "Totallugares",
            round(
            (SELECT COUNT(*) FROM bilhetes bil
            WHERE bil.sessao_id = ses.id)*100/
            (SELECT COUNT(*)
            FROM lugares lug
            WHERE lug.sala_id = ses.sala_id),2
            )AS "TaxaOcupação" 
              
            FROM sessoes ses
            LEFT JOIN filmes fil
            ON ses.filme_id=fil.id
            WHERE fil.id = "'.$filme->id.'"ORDER BY round(
            (SELECT COUNT(*) FROM bilhetes bil
            WHERE bil.sessao_id = ses.id)*100/
            (SELECT COUNT(*)
            FROM lugares lug
            WHERE lug.sala_id = ses.sala_id),2
            ) asc');
        }
        if ($request->ordenar == 2 ) {
          $sessoesFilme =DB::select('SELECT ses.*,(
            SELECT COUNT(*) FROM bilhetes bil
            WHERE bil.sessao_id = ses.id
            ) AS "BilhetesVendidos", 
            (
            SELECT COUNT(*) FROM bilhetes bil
            WHERE bil.sessao_id = ses.id
            AND bil.estado = "usado"
            ) AS "Usados",
            (
            SELECT COUNT(*) FROM bilhetes bil
            WHERE bil.sessao_id = ses.id
            AND bil.estado = "não usado"
            ) AS "Naousados",
            (
            SELECT COUNT(*)
            FROM lugares lug
            WHERE lug.sala_id = ses.sala_id
            ) AS "Totallugares",
            round(
            (SELECT COUNT(*) FROM bilhetes bil
            WHERE bil.sessao_id = ses.id)*100/
            (SELECT COUNT(*)
            FROM lugares lug
            WHERE lug.sala_id = ses.sala_id),2
            )AS "TaxaOcupação" 
              
            FROM sessoes ses
            LEFT JOIN filmes fil
            ON ses.filme_id=fil.id
            WHERE fil.id = "'.$filme->id.'"ORDER BY round(
            (SELECT COUNT(*) FROM bilhetes bil
            WHERE bil.sessao_id = ses.id)*100/
            (SELECT COUNT(*)
            FROM lugares lug
            WHERE lug.sala_id = ses.sala_id),2
            ) desc');
        }

      
      return view('estatisticas.bilhetes.sessoes')
                  ->with('filme', $filme)
                  ->with('sessoesFilme', $sessoesFilme);
    }

    // //OLDDDDDDDDDDDDDDDD
    // public static function totalLugaresSessao($sessao){
    //   $idSalaSessao = Sessao::where('id',$sessao)->pluck('sala_id');
    //   $totalLugaresSessao = Lugares::where('sala_id',$idSalaSessao)->count();
    //   return $totalLugaresSessao;
    // }
    // public static function totalBilhetesVendidos($sessao){
    //   $totalBilhetesVendidos = Bilhetes::where('sessao_id',$sessao)->count();
    //   return $totalBilhetesVendidos;
    // }
    // public static function totalBilhetesVendidosUsados($sessao){
    //   $totalBilhetesVendidosUsados = Bilhetes::where('sessao_id',$sessao)
    //                                             ->where('estado','=','usado')
    //                                             ->count();
    //   return $totalBilhetesVendidosUsados;
    // }
    // public static function totalBilhetesVendidosNaoUsados($sessao){
    //   $totalBilhetesVendidosNaoUsados = Bilhetes::where('sessao_id',$sessao)
    //                                             ->where('estado','=','não usado')
    //                                             ->count();
    //   return $totalBilhetesVendidosNaoUsados;
    // }

    // public static function taxaOcupacaoSessao($sessao){

    //   $idSalaSessao = Sessao::where('id',$sessao)->pluck('sala_id');
    //   $totalLugaresSessao = Lugares::where('sala_id',$idSalaSessao)->count();
    //   $totalBilhetesVendidos = Bilhetes::where('sessao_id',$sessao)->count();
    //   $taxaOcupacaoSessao = round(($totalBilhetesVendidos*100)/$totalLugaresSessao,2).'%';

    //   return $taxaOcupacaoSessao;
    // }


    public function export() 
    {
        return Excel::download(new EstatisticasController, 'excel.xlsx');
    }

}
