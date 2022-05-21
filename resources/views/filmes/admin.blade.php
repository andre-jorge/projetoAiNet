@extends('home')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">titulo</th>
                <th scope="col">genero_code.</th>
                <th scope="col">ano</th>
                <th scope="col">cartaz_url</th>
                <th scope="col">sumario</th>
                <th scope="col">trailer_url</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($filmes as $filme)
            <tr>
                <td>{{$filme->id}}</td>
                <td>{{$filme->titulo}}</td>
                <td>{{$filme->genero_code}}</td>
                <td>{{$filme->ano}}</td>
                <td>{{$filme->cartaz_url}}</td>
                <td>{{$filme->sumario}}</td>
                <td>{{$filme->trailer_url}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection