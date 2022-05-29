@extends('home')

@section('content')  
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
                </tr>
        </thead>
        <tbody>
            @foreach ($recibos as $dados)
            <tr>
                <td>{{$dados->id}}</td>
                <td>{{$dados->data}}</td>
                <td>{{$dados->preco_total_sem_iva}}</td>
                <td>{{$dados->iva}}</td>
                <td>{{$dados->preco_total_com_iva}}</td>
                <td>{{$dados->NIF}}</td>
                <td>{{$dados->tipo_pagamento}}</td>
                <td>{{$dados->ref_pagamento}}</td>
                <td>
                    <a href="{{ route('pdf.recibo', $dados->id ) }}" name="recibo" value='{{$dados}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Ver Recibo</a>
                </td>
            </tr>
            @endforeach
        </tbody>
        
    </table>
    {{ $recibos->links() }}
</div> 

@endsection