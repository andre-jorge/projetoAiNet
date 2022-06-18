@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Totais Anual</h1></strong></h3>
</div>
<br>
<br>
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
        @foreach ($totaisAnual as $totais)
        <tr>
            <td>{{ $totais['year(data)'] }}</td>
            <td>{{$totais->PrecoTotalSiva}}</td>
            <td>{{$totais->iva}}</td>
            <td>{{$totais->PrecoTotalCiva}}</td>
        </tr>
        @endforeach
        <a href="{{action('EstatisticasController@export')}}">Export</a>
    </tbody>
</table>

@endsection