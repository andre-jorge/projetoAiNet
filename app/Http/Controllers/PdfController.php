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
        $bilhetes = Bilhetes::where('recibo_id',$recibo->id)->get();
        //dd($bilhetes);
        $pdf = PDF::loadView('pdf.bilhete', compact('bilhetes'));
        //dd($pdf);
        return $pdf->setPaper('A4')->stream('bilhete.pdf');
    }

    public function geraPdfRecibo(Recibo $recibo)
    {
        //dd($recibo);
        $recibo = Recibo::findOrFail($recibo->id);
        $sessoes = Bilhetes::where('recibo_id',$recibo->id)->get();
        //dd($sessoes);
        $pdf = PDF::loadView('pdf.recibo', compact('recibo', 'sessoes'));
        //dd($pdf);
        //guardar pdf em projeto\public\storage\pdf com nome (1.pdf)
        // $path = public_path('storage/pdf');
        // $fileName =  $recibo['id'] . '.' . 'pdf' ;
        // $pdf->save($path . '/' . $fileName);
        return $pdf->setPaper('A4')->stream('recibo.pdf');
    }

    public function indexRecibo()
      {
         $recibos = Recibo::paginate(8);
         //dd($recibos);
         return view('pdf.indexRecibo', compact('recibos'));
      }
}
