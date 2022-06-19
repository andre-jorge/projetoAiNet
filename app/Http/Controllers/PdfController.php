<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bilhetes;
use App\Models\Recibo;
use App\Models\User;
use PDF;
use QrCode;

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

    public function indexRecibo(Request $request)
      {
        if (is_null($request->reciboid) and is_null($request->data) and is_null($request->clientenome) and is_null($request->nif) and is_null($request->tipo_pagamento)) {
            $recibos = Recibo::paginate(8);
            return view('pdf.indexRecibo', compact('recibos'));
        }
        
        if ($request->reciboid != null) {
            $recibos = Recibo::where('id',$request->reciboid)->paginate(8);
            return view('pdf.indexRecibo', compact('recibos'));
        }
        //data
        if ($request->data != null) {
            $recibos = Recibo::where('data',$request->data)->paginate(8);
            return view('pdf.indexRecibo', compact('recibos'));
        }
        //clientenome
        if ($request->clientenome != null) {
            $clienteid = User::where('name', 'like', '%' . $request->clientenome . '%')
                        ->pluck('id');

            $recibos = Recibo::whereIn('cliente_id',$clienteid)->paginate(8);
            return view('pdf.indexRecibo', compact('recibos'));
        }
        //nif
        if ($request->nif != null) {
            $recibos = Recibo::where('nif',$request->nif)->paginate(8);
            return view('pdf.indexRecibo', compact('recibos'));
        }
        //nif
        if ($request->tipo_pagamento != 'TODOS') {
            $recibos = Recibo::where('tipo_pagamento',$request->tipo_pagamento)->paginate(8);
            return view('pdf.indexRecibo', compact('recibos'));
        }
            $recibos = Recibo::paginate(8);
               
        return view('pdf.indexRecibo', compact('recibos'));
      }
}
