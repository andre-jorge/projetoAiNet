@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Filmes e Sessões</h1></strong></h3>
</div>
<br>
<form  action="{{route('filmes.admin')}}" method="GET">
<div class="row mb-2">
    <div class="col-sm-5 col-md-5">
        <!-- STRING -->
        <input type="search" name="string" id="string" class="form-control rounded" placeholder="Pesquisar por Titulo ou Sumario" aria-label="Search" aria-describedby="search-addon" />    
        <!-- STRING --> 
    </div>
    <div class="col-sm-5 col-md-5">
    
        <!-- Tipo -->
        <select class="form-select" name="genero" id="inputGroupSelect04">
                <option value="Genero" >
                   Genero
                </option>
            @foreach ($listaGeneros as $gen)
                <option value="{{$gen->code}}" {{$gen->nome == $gen->code ?  : 'Todos'}}>
                    {{$gen->nome}}
                </option>
            @endforeach
        </select>
        <!-- Tipo -->
    </div>  
    <div class="col-sm-5 col-md-2 .ml-md-auto" >
        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Pesquisar</button>
    </div>
</div>
</form>     
<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">titulo</th>
                <!-- <th scope="col">genero_code</th>
                <th scope="col">ano</th> -->
                <th scope="col">sumario</th>
                <th scope="col"></th>
                <th scope="col">
                <form method="get" action="{{route('filmes.create')}}">
                    <button style="float: right;" class="btn btn-outline-dark" href="{{route('filmes.store')}}">Novo Filme</button>
                </form>
                </th>
                <th scope="col">
                <form method="get" action="{{route('sessoes.admin.create')}}">
                    <button style="float: right;" class="btn btn-outline-dark" href="{{route('sessoes.admin.store')}}">Nova Sessão</button>
                </form>
                </th>
                </tr>
        </thead>
        <tbody>
            @foreach ($filmes as $filme)
            <tr>
                <td><img class="rounded" style="max-height: 100px; max-width: 100px;" src="/storage/cartazes/{{$filme->cartaz_url ?? 'CineMagic.png'}}" alt="..." /></td>
                <td>{{$filme->titulo}}</td>
                <!-- <td>{{$filme->genero_code}}</td>
                <td>{{$filme->ano}}</td> -->
                <td>{{$filme->sumario}}</td>
                <td><a href="{{ route('filmes.edit', $filme) }}" class="btn btn-outline-dark" role="button" aria-pressed="true">Alterar</a></td>
                <td>
                    <form method="post" action="{{ route('filmes.destroy', $filme) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-outline-danger" onclick="return confirm('Pretende eleminar?')" value="Eliminar">
                    </form> 
                
                <td><a href="{{ route('sessoes.admin.index', $filme) }}" name="id" value='{{$filme->id}}' class="btn btn-outline-dark" role="button" aria-pressed="true">Sessoes</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
            {!! $filmes->links() !!}
    </div>
</div>
@endsection