@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Totais Mensais</h1></strong></h3>
</div>
<br>
<br>
<form  action="{{route('estatisticas.totais.mensal')}}" method="GET">
<div class="row mb-2">
    <label for="datainicio">Ano</label>
    <div class="col-sm-10 col-md-10">
        <!-- datainicio --> 
        <input type="year" name="ano" id="ano" class="form-control rounded" placeholder="Data" aria-label="Search" aria-describedby="search-addon" @if($anoPedido != '0') value="{{$anoPedido}}" @endif />    
        <!-- datainicio -->
    </div>
    <div class="col-sm-2 col-md-2 .ml-md-auto" >
        <label for="submit"></label>
        <button type="submit" name="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Pesquisar</button>
        <a href="{{action('App\Http\Controllers\EstatisticasController@export')}}">Export</a>
    </div>
</div>
</form> 
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Mês</th>
            <th scope="col">Total S/Iva</th>
            <th scope="col">Total Iva </th>
            <th scope="col">Total c/Iva</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($totaisMensal as $totais)
        <tr>
            <td>{{ $totais['month(data)'] }}</td>
            <td>{{$totais->PrecoTotalSiva}}</td>
            <td>{{$totais->iva}}</td>
            <td>{{$totais->PrecoTotalCiva}}</td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection