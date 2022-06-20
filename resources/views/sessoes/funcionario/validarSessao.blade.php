@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Validar Sessao Filme {{$sessao->Filmes->titulo}}</h1></strong></h3>
<h3 class="align-middle">Data: {{$sessao->data}} / Hora: {{$sessao->horario_inicio}}</h3>
</div>
<br>
<br>
<form  action="{{route('sessoes.funcionario.validaBilhetePorId', $sessao)}}" method="GET">
<div class="row mb-2">
    <div class="col-sm-5 col-md-5">
         
    </div>
    <div class="col-sm-5 col-md-5">
        <!-- STRING -->
        <input type="search" name="string" id="string" class="form-control rounded" placeholder="Numero Bilhete ou projeto.test\bilhete/(idbilhete) " aria-label="Search" aria-describedby="search-addon" />    
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
                <th scope="col">Nº Bilhete</th>
                <th scope="col">Nº Recibo</th>
                <th scope="col">Cliente</th>
                <th scope="col">Nº Sessao</th>
                <th scope="col">Lugar</th>
                <th scope="col">Estado</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($todosBilhetes as $bilhete)  
            <tr>
                <td>{{$bilhete->id}}</td> 
                <td>{{$bilhete->recibo_id}}</td> 
                <td>{{$bilhete->cliente_id}}</td>
                <td>{{$bilhete->sessao_id}}</td>  
                <td>{{$bilhete->Lugares->fila}} | {{$bilhete->Lugares->posicao}}</td>
                <td>{{$bilhete->estado}}</td>
                <td>
                <a href="{{route('sessoes.funcionario.validaBilhete', $bilhete)}}" name="user" value="{{$bilhete}}" class="btn btn-outline-success" role="button" aria-pressed="true">Validar Bilhete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {!! $todosBilhetes->links() !!}
    </div> 
</div>
@endsection