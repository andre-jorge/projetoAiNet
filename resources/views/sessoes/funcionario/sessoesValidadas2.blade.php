@extends('home')

@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Sessao Já Validadas do Filme {{$sessao->Filmes->titulo}}</h1></strong></h3>
<h3 class="align-middle">Data: {{$sessao->data}} / Hora: {{$sessao->horario_inicio}}</h3>
</div>
<br>
<br>
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
            </tr>
            @endforeach
        </tbody>
        
    </table>
    <div class="d-flex justify-content-center">
        {!! $todosBilhetes->links() !!}
    </div> 
    
</div>



@endsection