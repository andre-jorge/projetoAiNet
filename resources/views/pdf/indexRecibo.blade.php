@extends('home')
@section('content')
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Num_Recibo</th>
            <th scope="col">Cliente</th>
            <th scope="col">Data Recibo</th>
            <th scope="col">Total s/Iva</th>
            <th scope="col">Iva</th>
            <th scope="col">Total c/Iva</th>
            <th scope="col">NIF</th>
            <th scope="col">Nome Cliente</th>
            <th scope="col">Tipo Pagamento</th>
            <th scope="col">Ref Pagamento</th>
            <th scope="col">Recibo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recibos as $recibo)
        <tr>
            <td>{{$recibo->id}}</td>
            <td>{{$recibo->cliente_id}}</td>
            <td>{{$recibo->data}}</td>
            <td>{{$recibo->preco_total_sem_iva}}</td>
            <td>{{$recibo->iva}}</td>
            <td>{{$recibo->preco_total_com_iva}}</td>
            <td>{{$recibo->nif}}</td>
            <td>{{$recibo->nome_cliente}}</td>
            <td>{{$recibo->tipo_pagamento}}</td>
            <td>{{$recibo->ref_pagamento}}</td>
            <td>
            <a href="{{ route('pdf.recibo', $recibo->id ) }}" name="recibo" value='{{$recibo}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Ver Recibo</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $recibos->links() }}

@endsection