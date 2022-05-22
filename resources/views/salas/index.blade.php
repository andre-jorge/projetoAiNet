@extends('home')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">Numero Sala</th>
                <th scope="col">Sala</th>
                <th scope="col">Editar nome</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salas as $sala)
            <tr>
                <td><img class="img-fluid" src="/storage/cartazes/{{$sala->costum}}" alt="..." /></td>
                <td>{{$sala->id}}</td>
                <td>{{$sala->nome}}</td>
                <td><a class="btn btn-outline-dark mt-auto" name="salaid" value='{{$sala->id}}' href="{{ route('salas.edit', $sala->id) }}">Editar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection