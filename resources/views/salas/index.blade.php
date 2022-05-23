@extends('home')
@section('content')
<form method="get" action="{{route('salas.create')}}">
    <button class="btn btn-secondary" href="{{route('salas.store')}}">Novo</button>
</form> 
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">Numero Sala</th>
                <th scope="col">Sala</th>
                <th scope="col">Lotação Maxima</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($todassalas as $sala)
            <tr>
                <td></td>
                <td>{{$sala->id}}</td>
                <td>{{$sala->nome}}</td>
                <td>{{$sala->costum}}</td>
                <td>
                <a href="{{ route('salas.edit', $sala->id, $sala->nome) }}" name="salaid" value='{{$sala->id}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Alterar</a>
                <td>
                    <form method="post" action="{{ route('salas.destroy', $sala->id) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-danger btn-sm" value="Eliminar">
                    </form> 
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection