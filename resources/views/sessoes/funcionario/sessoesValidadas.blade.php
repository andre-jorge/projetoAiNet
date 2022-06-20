@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Todas Sessoes com Bilhetes Validados</h1></strong></h3>
</div>
<br>
<br>
<form  action="{{route('sessoes.funcionario.sessoesValidadas')}}" method="GET">
<div class="row mb-2">
    <div class="col-sm-5 col-md-5">    
    </div>
    <div class="col-sm-5 col-md-5">
        <!-- STRING -->
        <input type="search" name="string" id="string" class="form-control rounded" placeholder="Numero Sessao" aria-label="Search" aria-describedby="search-addon" />    
        <!-- STRING --> 
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
                <th scope="col"></th>
                <th scope="col">Titulo</th>
                <th scope="col">Data</th>
                <th scope="col">Hora</th>
                <th scope="col">Sala</th>
                <th scope="col">Validar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sessoesValidadas as $sessao)  
            <tr>
                <td><img class="rounded" style="max-height: 150px; max-width: 150px;" src="/storage/cartazes/{{$sessao->Filmes->cartaz_url ?? 'default-profile.png'}}" alt="..." /></td>
                <td>{{$sessao->Filmes->titulo}}</td> 
                <td>{{$sessao->data}}</td>
                <td>{{$sessao->horario_inicio}}</td>
                <td>{{$sessao->Salas->nome}}</td>   
                <td>
                    <a href="{{route('sessoes.funcionario.sessoesValidadas2', $sessao)}}" class="btn btn-outline-dark" role="button" aria-pressed="true">Ver Bilhetes</a>
                </td>
            </tr>
            @endforeach
        </tbody>
        
    </table>
    <div class="d-flex justify-content-center">
        {!! $sessoesValidadas->links() !!}
    </div>   
</div>
@endsection