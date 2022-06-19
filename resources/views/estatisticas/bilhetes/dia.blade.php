@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Totais Diarios</h1></strong></h3>
</div>
<br>
<br>

<form  action="{{route('estatisticas.bilhetes.dia')}}" method="GET">
<div class="row mb-2">
    <label for="datainicio">Mês/Ano</label>
    <div class="col-sm-10 col-md-10">
        <!-- datainicio --> 
        <input type="date" name="datainicio" id="datainicio" class="form-control rounded" placeholder="Data" aria-label="Search" aria-describedby="search-addon"  />    
        <!-- datainicio -->
    </div>
    <div class="col-sm-2 col-md-2 .ml-md-auto" >
        <label for="submit"></label>
        <button type="submit" name="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Pesquisar</button>
    </div>
</div>
</form> 
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Data</th>
            <th scope="col">Total S/Iva</th>
            <th scope="col">Total Iva </th>
            <th scope="col">Total c/Iva</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($totaisDiarios as $totais)
        <tr>
            <td>{{$totais->data}}</td>
            <td>{{$totais->PrecoTotalSiva}}</td>
            <td>{{$totais->iva}}</td>
            <td>{{$totais->PrecoTotalCiva}}</td>
        </tr>
        @endforeach
        
    </tbody>
    
</table>

@endsection