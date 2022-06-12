@extends('home')

@section('content')
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
            @foreach ($sessoesValidar as $sessao)  
            <tr>
                <td><img class="rounded" style="max-height: 150px; max-width: 150px;" src="/storage/cartazes/{{$sessao->Filmes->cartaz_url ?? 'default-profile.png'}}" alt="..." /></td>
                <td>{{$sessao->Filmes->titulo}}</td> 
                <td>{{$sessao->data}}</td>
                <td>{{$sessao->horario_inicio}}</td>
                <td>{{$sessao->Salas->nome}}</td>   
                <td>
                    <a href="{{route('sessoes.funcionario.validarSessao', $sessao)}}" class="btn btn-outline-dark" role="button" aria-pressed="true">Validar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
        
    </table>
    
</div>



@endsection