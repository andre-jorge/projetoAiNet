@extends('home')
@section('content')   
<form method="get" action="{{route('filmes.create')}}">
    <button class="btn btn-secondary" href="{{route('filmes.store')}}">Novo</button>
</form>  
<div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">titulo</th>
                <th scope="col">genero_code</th>
                <th scope="col">ano</th>
                <th scope="col">cartaz_url</th>
                <th scope="col">sumario</th>
                <th scope="col">trailer_url</th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
        </thead>
        <tbody>
            @foreach ($filmes as $filme)
            <tr>
                <td><img class="img-fluid" src="/storage/cartazes/{{$filme->cartaz_url}}" alt="..." /></td>
                <td>{{$filme->titulo}}</td>
                <td>{{$filme->genero_code}}</td>
                <td>{{$filme->ano}}</td>
                <td>{{$filme->cartaz_url}}</td>
                <td>{{$filme->sumario}}</td>
                <td>{{$filme->trailer_url}}</td>
                <td><a href="{{ route('filmes.edit', $filme->id, $filme->titulo) }}" name="filmeid" value='{{$filme->id}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                <td>
                    <form method="post" action="{{ route('filmes.destroy', $filme->id) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-danger btn-sm" value="Eliminar">
                    </form> 
                </tr>
            </tr>
            @endforeach
        </tbody>
        
    </table>
    {{ $filmes->links() }}
</div>   
@endsection