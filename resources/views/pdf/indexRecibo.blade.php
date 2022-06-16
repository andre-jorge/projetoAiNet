@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Recibos Clientes</h1></strong></h3>
</div>
<br>
<br>
<form  action="{{route('pdf.indexRecibo')}}" method="GET">
<div class="row mb-2">
    <div class="col-sm-2 col-md-2">
        <!-- reciboid -->
        <input type="number" name="reciboid" id="reciboid" class="form-control rounded" placeholder="Numero Recibo" aria-label="Search" aria-describedby="search-addon" />    
        <!-- ReciboID --> 
    </div>
    <div class="col-sm-2 col-md-2">
        <!-- data -->
        <input type="date" name="data" id="data" class="form-control rounded" placeholder="Data" aria-label="Search" aria-describedby="search-addon" />    
        <!-- data --> 
    </div>
    <div class="col-sm-2 col-md-2">
        <!-- clientenome -->
        <input type="search" name="clientenome" id="clientenome" class="form-control rounded" placeholder="Nome Cliente" aria-label="Search" aria-describedby="search-addon" />    
        <!-- clientenome --> 
    </div>
    <div class="col-sm-2 col-md-2">
        <!-- nif -->
        <input type="search" name="nif" id="nif" class="form-control rounded" placeholder="NIF" aria-label="Search" aria-describedby="search-addon" />    
        <!-- nif --> 
    </div> 
    <div class="col-sm-2 col-md-2">
        <!-- tipo_pagamento -->
        <select class="form-select" name="tipo_pagamento" id="tipo_pagamento">
                <option value="TODOS">Todos</option>
                <option value="PAYPAL">Paypal</option>
                <option value="MBWAY">MBWAY</option>
                <option value="VISA">Visa</option>
        </select>
        <!-- tipo_pagamento -->
    </div>  
    <div class="col-sm-5 col-md-2 .ml-md-auto" >
        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Pesquisar</button>
    </div>
</div>
</form> 
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Recibo</th>
            <th scope="col">Cliente</th>
            <th scope="col">Data </th>
            <th scope="col">Total c/Iva</th>
            <th scope="col">NIF</th>
            <th scope="col">Tipo Pagamento</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recibos as $recibo)
        <tr>
            <td>{{$recibo->id}}</td>
            <td>{{$recibo->nome_cliente}}</td>
            <td>{{$recibo->data}}</td>
            <td>{{$recibo->preco_total_com_iva}}</td>
            <td>{{$recibo->nif}}</td>
            <td>{{$recibo->tipo_pagamento}}</td>
            <td>
                <a href="{{ route('pdf.recibo', $recibo->id ) }}" name="recibo" value='{{$recibo}}' class="btn btn-info" role="button" aria-pressed="true">Recibo</a>
            </td>
            <td>
                <a href="{{ route('pdf.bilhete', $recibo->id ) }}" name="bilhetes" value='{{$recibo}}' class="btn btn-info" role="button" aria-pressed="true">Bilhete(s)</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $recibos->links() }}

@endsection