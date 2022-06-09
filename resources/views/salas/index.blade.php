@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Salas</h1></strong></h3>
</div>
<br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Sala</th>
                <th scope="col">Lotação</th>
                <th scope="col"></th>
                <th scope="col">
                    <form method="get" action="{{route('salas.create')}}">
                        <button style="float: right;" class="btn btn-outline-dark" href="{{route('salas.store')}}">Nova Sala</button>
                    </form>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($todassalas as $salas)
            <tr>
                <td>{{$salas->nome}}</td>
                <td>{{$salas->custom}}</td>
                <td>
                <a style="float: right;" class="btn btn-outline-dark" href="{{ route('salas.edit', $salas) }}" name="salaid" value='{{$salas}}' role="button" aria-pressed="true">Alterar</a>
                </td>
                @if(is_null($salas->deleted_at))
                    <td>
                    <a href="{{ route('salas.index.recuperar', $salas) }}" style="float: right;" name="salas" value='{{$salas}}' class="btn btn-outline-danger" role="button" aria-pressed="true">&nbsp&nbspEliminar&nbsp&nbsp</a>
                    </td>
                @else
                    <td>
                    <a href="{{ route('salas.index.recuperar', $salas) }}" style="float: right;" name="salas" value='{{$salas}}' class="btn btn-outline-success" role="button" aria-pressed="true">Recuperar</a>
                    </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection