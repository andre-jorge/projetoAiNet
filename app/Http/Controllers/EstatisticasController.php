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
use App\Exports\DiarioExport;
use App\Exports\MensalExport;
use App\Exports\AnualExport;
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
      $datas = array(
        "data"=> $dataInicio,
        "data2"=> $dataFim,
        );

      return view('estatisticas.totais.diarios')
              ->with('datas', $datas)
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
      $datas = array(
        "data"=> $dataInicio,
        "data2"=> $dataFim,
        );        
      return view('estatisticas.totais.mensal')
              ->with('datas', $datas)
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

    public function estatisticas_bilhetes_dia(Request $request) 
    {
      if ($request->data) {
        $date = $request->get('data');
        //$newDate = date('d-m-Y', strtotime($date));

        $dataInicio = date('Y-m-d', strtotime($date));
        $dataInicioxpto = date('d-m-Y', strtotime($date));
        $dataMenos7Dias = date('Y-m-d', strtotime('-7 days', strtotime($dataInicio)));
        $dataMenos30Dias = date('Y-m-d', strtotime('-30 days', strtotime($dataInicio)));
      }else {
        $dataInicio = Carbon::now()->format('Y-m-d');
        $dataInicioxpto = Carbon::now()->format('d-m-Y');
        $dataMenos7Dias = date('Y-m-d', strtotime('-7 days', strtotime($dataInicio)));
        $dataMenos30Dias = date('Y-m-d', strtotime('-30 days', strtotime($dataInicio)));
      }
      
      //dd($dataMenos30Dias);
      $totaisDiarios = Recibo::where('data','=',$dataInicio)
                          ->select(DB::raw("SUM(preco_total_sem_iva) as PrecoTotalSiva, SUM(iva) as iva, SUM(preco_total_com_iva) as PrecoTotalCiva, data"))
                          ->groupBy('data')
                          ->get(); 
       // dd($totaisDiarios); 
      $sessoesDia = Sessao::where('data','=',$dataInicio)->pluck('id');
      $sessoesFilmes = Sessao::where('data','=',$dataInicio)->distinct('filme_id')->count();
      $totalSessoesDia = $sessoesDia->count();
      $totalRecibosCount = Recibo::where('data','=',$dataInicio)->count();
      //clientes
      $totalCliente = Cliente::count();
      $clientesNovosHoje = Cliente::where('created_at',$dataInicio)->count();
      $clientesBloqueados = User::where('tipo','=','C')->where('bloqueado','=','1')->count();
      $clientesEleminados = User::withTrashed()->where('deleted_at','!=','null')->count();
      $melhoresClientes30Dias = DB::select('SELECT SUM(recibos.preco_total_com_iva) as "soma",users.name as name, users.foto_url AS foto_url, users.id AS id  FROM recibos 
      LEFT JOIN users 
      ON users.id = recibos.cliente_id
      WHERE recibos.data between "'.$dataMenos30Dias.'" and "'.$dataInicio.'"
      GROUP BY users.name, users.foto_url, users.id
      ORDER BY SUM(recibos.preco_total_com_iva) DESC limit 3');
      $melhoresClientes7Dias = DB::select('SELECT SUM(recibos.preco_total_com_iva) as "soma",users.name as name, users.foto_url AS foto_url, users.id AS id  FROM recibos 
      LEFT JOIN users 
      ON users.id = recibos.cliente_id
      WHERE recibos.data between "'.$dataMenos7Dias.'" and "'.$dataInicio.'"
      GROUP BY users.name, users.foto_url, users.id
      ORDER BY SUM(recibos.preco_total_com_iva) DESC limit 3');
      //dd($melhoresClientes);
      
         
      $totalBilhetesVendidosDia = Bilhetes::whereIn('sessao_id',$sessoesDia)->count();
      //dd($totalBilhetesVendidosDia);            
      return view('estatisticas.bilhetes.dia')
              ->with('totalCliente', $totalCliente)
              ->with('clientesNovosHoje', $clientesNovosHoje)
              ->with('clientesBloqueados', $clientesBloqueados)
              ->with('clientesEleminados', $clientesEleminados)
              ->with('melhoresClientes30Dias', $melhoresClientes30Dias)
              ->with('melhoresClientes7Dias', $melhoresClientes7Dias)
              ->with('sessoesDia', $sessoesDia)
              ->with('totalRecibosCount', $totalRecibosCount)
              ->with('sessoesFilmes', $sessoesFilmes)
              ->with('totalSessoesDia', $totalSessoesDia)
              ->with('totalBilhetesVendidosDia', $totalBilhetesVendidosDia)
              ->with('dataInicioxpto', $dataInicioxpto)
              ->with('dataInicio', $dataInicio)
              ->with('totaisDiarios', $totaisDiarios);
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

        //$data = $this->($sessoesFilme);
      return view('estatisticas.bilhetes.sessoes')
                  ->with('filme', $filme)
                  ->with('sessoesFilme', $sessoesFilme);
    }

    //exporta ecxel
    public function exportDiario(Request $request) 
    {
      return (new DiarioExport)->forDate($request->data,$request->data2)->download('TotalDiario.xlsx');
    }

    public function exportMensal(Request $request) 
    {
      return (new MensalExport)->forDate($request->data,$request->data2)->download('TotalMensal.xlsx');
    }

    public function exportAnual() 
    {
      return (new AnualExport)->download('TotalAnual.xlsx');
    }
}
