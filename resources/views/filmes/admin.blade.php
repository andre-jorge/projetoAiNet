@extends('home')
@section('content')   
<div class="row mb-3">
    <div class="col-md-6" style="width: 500px;">
        <form method="get" action="{{route('filmes.create')}}">
            <button class="btn btn-primary btn-block" href="{{route('filmes.store')}}">Novo Filme</button>
        </form>
    </div>   
    <div class="col-md-6" style="width: 500px;">
        <form method="get" action="{{route('sessoes.admin.create')}}">
            <button class="btn btn-primary btn-block" href="{{route('sessoes.admin.store')}}">Nova Sessão</button>
        </form> 
    </div>
</div>  
<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">titulo</th>
                <!-- <th scope="col">genero_code</th>
                <th scope="col">ano</th> -->
                <th scope="col">sumario</th>
                <th scope="col">trailer_url</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
        </thead>
        <tbody>
            @foreach ($filmes as $filme)
            <tr>
                <td><img class="img-thumbnail" src="/storage/cartazes/{{$filme->cartaz_url}}" alt="..." /></td>
                <td>{{$filme->titulo}}</td>
                <!-- <td>{{$filme->genero_code}}</td>
                <td>{{$filme->ano}}</td> -->
                <td>{{$filme->sumario}}</td>
                <td>{{$filme->trailer_url}}</td>
                <td><a href="{{ route('filmes.edit', $filme) }}" class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                <td>
                    <form method="post" action="{{ route('filmes.destroy', $filme) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Pretende eleminar?')" value="Eliminar">
                    </form> 
                
                <td><a href="{{ route('sessoes.admin.index', $filme) }}" name="id" value='{{$filme->id}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Sessoes</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $filmes->links() }}
</div>   
@endsection