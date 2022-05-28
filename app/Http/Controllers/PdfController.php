<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bilhetes;
use App\Models\Recibo;
use PDF;

class PdfController extends Controller
{
    public function geraPdfBilhete(Recibo $recibo)
    {
        //dd($recibo);
        $bilhete = Bilhetes::where('recibo_id',$recibo->id);
        //dd($bilhete);
        $pdf = PDF::loadView('pdf.bilhete', compact('bilhete'));
        //dd($pdf);
        return $pdf->setPaper('a6')->stream('bilhete.pdf');
    }

    public function geraPdfRecibo(Recibo $recibo)
    {
        //dd($recibo);
        $recibo = Recibo::findOrFail($recibo->id);
        //dd($bilhete);
        $pdf = PDF::loadView('pdf.recibo', compact('recibo'));
        //dd($pdf);
        return $pdf->setPaper('A4')->stream('recibo.pdf');
    }

    public function indexRecibo()
      {
         $recibos = Recibo::paginate(8);
         //dd($recibos);
         return view('pdf.indexRecibo', compact('recibos'));
      }
}
