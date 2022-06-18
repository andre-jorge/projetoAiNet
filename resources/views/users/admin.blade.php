@extends('home')

@section('content') 
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Clientes</h1></strong></h3>
</div>
<br>
<br>
<form  action="{{route('users.admin')}}" method="GET">
<div class="row mb-2">
    <div class="col-sm-5 col-md-5">
        <!-- STRING -->
        <input type="search" name="string" id="string" class="form-control rounded" placeholder="Pesquisar por Nome ou Email" aria-label="Search" aria-describedby="search-addon" />    
        <!-- STRING --> 
    </div>
    <div class="col-sm-5 col-md-5">
        <!-- NIF -->
        <input type="search" name="nif" id="nif" class="form-control rounded" placeholder="NIF" aria-label="Search" aria-describedby="search-addon" />    
        <!-- NIF --> 
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
                <td>{{$user->Cliente->nif ?? ' '}}</td>
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