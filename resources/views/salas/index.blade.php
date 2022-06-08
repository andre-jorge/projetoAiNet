@extends('home')
@section('content')
<form method="get" action="{{route('salas.create')}}">
    <button style="float: left;" class="btn btn-primary btn-block" href="{{route('salas.store')}}">Nova Sala</button>
</form> 
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Sala</th>
                <th scope="col">Lotação</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($todassalas as $sala)
            <tr>
                <td>{{$sala->nome}}</td>
                <td>{{$sala->custom}}</td>
                <td>
                <a href="{{ route('salas.edit', $sala->id, $sala->nome) }}" name="salaid" value='{{$sala->id}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Alterar</a>
                <td>
                    <form method="post" action="{{ route('salas.destroy', $sala->id) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" onclick="return confirm('Pretende eleminar?')" class="btn btn-danger btn-sm" value="Eliminar">
                    </form> 
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection