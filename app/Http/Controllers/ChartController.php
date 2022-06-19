<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Sessao;
use App\Models\Lugares;
use App\Models\Recibo;
use App\Models\User;
use App\Models\Bilhetes;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function barChart(){
       $users = User::select(DB::raw("COUNT(*) as count"))
                    ->whereYear('created_at',date('Y'))
                    ->groupby(DB::raw("Month(created_at)")) 
                    ->pluck('count');
       $months = User::select(DB::raw("Month(created_at) as month"))
                    ->whereYear('created_at',date('Y'))
                    ->groupby(DB::raw("Month(created_at)")) 
                    ->pluck('month');

        $datas = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($months as $index => $month) {
           $datas[$month] = $users[$index];
        }
        return view('estatisticas.bar-chart')
                    ->with('datas', $datas);

    }

}