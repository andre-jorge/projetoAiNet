@extends('home')

@section('content')

<div class="container text-center"
<h3 class="align-middle" ><strong><h1 class="align-middle" style="background-color:green;">Recibo {{$recibo->id}} emitido com Sucesso </h1></strong></h3>
<h3 class="align-middle"><strong><h1 class="align-middle">Recibo e Bilhetes</h1></strong></h3>
</div>
<br>
<br>  
<div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Recibo #</th>
                <th scope="col">Data</th>
                <th scope="col">Preço S/IVA</th>
                <th scope="col">IVA</th>
                <th scope="col">Preço C/IVA</th>
                <th scope="col">NIF</th>
                <th scope="col">tipo_pagamento</th>
                <th scope="col">ref_pagamento</th>
                <th scope="col">Enviar Recibo Email</th>
                </tr>
        </thead>
        <tbody>
            
            <tr>
                <td>{{$recibo->id}}</td>
                <td>{{$recibo->data}}</td>
                <td>{{$recibo->preco_total_sem_iva}}</td>
                <td>{{$recibo->iva}}</td>
                <td>{{$recibo->preco_total_com_iva}}</td>
                <td>{{$recibo->NIF}}</td>
                <td>{{$recibo->tipo_pagamento}}</td>
                <td>{{$recibo->ref_pagamento}}</td>
                <td><a href="{{ route('pdf.recibo', $recibo->id ) }}" name="recibo" value='{{$recibo}}' class="btn btn-info" role="button" aria-pressed="true">Ver Recibo</a>
                </td>
                <td><a href="{{ route('pdf.bilhete', $recibo->id ) }}" name="bilhete" value='{{$recibo}}' class="btn btn-info" role="button" aria-pressed="true">Bilhete(s)</a>
                </td>
                </td>
                <td>
                <form action="{{ route('email.send_with_notification1') }}" method="POST">
                    @csrf
                    <input type="submit" value="Send Email With Mailable">
                </form>
                </td>
            </tr>
            
        </tbody>
        
    </table>
</div> 

@endsection