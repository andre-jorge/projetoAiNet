@extends('home')

@section('content') 
<div class="container text-center"
<h3 class="align-middle" ><strong><h1 class="align-middle" style="background-color:green;">Bilhete {{$bilheteId}} Validado com Sucesso </h1></strong></h3>
<h3 class="align-middle"><strong><h1 class="align-middle">Dados Cliente</h1></strong></h3>
</div>
<br>
<br>
<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">NIF</th>
                <th scope="col">Tipo Pagamento</th>
                <th scope="col">Ref. Pagamento</th>             
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
        </thead>
        <tbody>
            <tr>
                <td><img class="rounded" style="max-height: 150px; max-width: 150px;" src="/storage/fotos/{{$user->foto_url ?? 'default-profile.png'}}" alt="..." /></td>
                <td><?php 
                    $string = explode(' ', $user->name);
                    $first_word = $string[0];
                    $last_word  = $string[count($string)-1];
                    echo $first_word. ' '.$last_word; ?>
                </td>
                <td>{{$user->email}}</td>
                <td>{{$user->nif}}</td>
                <td>{{$user->Cliente->tipo_pagamento ?? ' '}} </td>
                <td>{{$user->Cliente->ref_pagamento ?? ' '}}</td>
                <td>
                @if($user->bloqueado == 1)
                <a href="{{ route('users.funcionarios.inativar', $user) }}" name="user" value='{{$user}}' class="btn btn-outline-danger" role="button" aria-pressed="true">&nbsp&nbsp&nbspDesbloquear&nbsp&nbsp&nbsp</a>
                @else
                <a href="{{ route('users.funcionarios.inativar', $user) }}" name="user" value='{{$user}}' class="btn btn-outline-success" role="button" aria-pressed="true">&nbsp&nbsp&nbspBloquear&nbsp&nbsp&nbsp</a>
                @endif    
                </td>
                <td> 
                
                <a href="{{route('sessoes.funcionario.validarSessao', $sessao)}}" name="sessao" value='{{$sessao}}' class="btn btn-outline-success" role="button" aria-pressed="true">&nbsp&nbsp&nbspContinuar&nbsp&nbsp&nbsp</a>
               
                </td>
            </tr>
        </tbody>   
    </table>
</div> 


@endsection