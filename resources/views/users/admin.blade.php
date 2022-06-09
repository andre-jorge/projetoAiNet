@extends('home')

@section('content')  
<div>
    <table class="table">
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
            @foreach ($dadosClientes as $user)
            <tr>
                <td><img class="rounded" style="max-height: 50px; max-width: 50px;" src="/storage/fotos/{{$user->foto_url ?? 'default-profile.png'}}" alt="..." /></td>
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
                @if($user->bloqueado == 0)
                <td>
                <a href="{{ route('users.funcionarios.inativar', $user) }}" name="user" value='{{$user}}' class="btn btn-outline-danger" role="button" aria-pressed="true">&nbsp&nbsp&nbspBloquear&nbsp&nbsp&nbsp</a>
                </td>
                @else
                <td>
                <a href="{{ route('users.funcionarios.inativar', $user) }}" name="user" value='{{$user}}' class="btn btn-outline-success" role="button" aria-pressed="true">Desbloquear</a>
                </td>
                @endif
                @if(is_null($user->deleted_at))  
                <td>  
                <a href="{{  route('users.funcionarios.recuperar', $user) }}" name="user" value='{{$user}}' class="btn btn-outline-danger" role="button" aria-pressed="true">Desativar</a>
                </td>
                @else
                <td>
                <a href="{{  route('users.funcionarios.recuperar', $user) }}" name="user" value='{{$user}}' class="btn btn-outline-success" role="button" aria-pressed="true">&nbsp&nbspAtivar&nbsp&nbsp&nbsp</a>
                </td>
                @endif
                </tr>
            </tr>
            @endforeach
        </tbody>
        
    </table>
    <div class="d-flex justify-content-center">
            {!! $dadosClientes->links() !!}
    </div>
</div> 


@endsection