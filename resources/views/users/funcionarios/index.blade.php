@extends('home')

@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Funcionarios e Administradores</h1></strong></h3>
</div>
<br>
<br>
<form  action="{{route('users.funcionarios.index')}}" method="GET">
<div class="row mb-2">
    <div class="col-sm-5 col-md-5">
        <!-- STRING -->
        <input type="search" name="string" id="string" class="form-control rounded" placeholder="Pesquisar por Nome ou Email" aria-label="Search" aria-describedby="search-addon" />    
        <!-- STRING --> 
    </div>
    <div class="col-sm-5 col-md-5">
        <!-- Tipo -->
        <select class="form-select" name="tipo" id="inputGroupSelect04">
            <option value="Todos" @if ($tipoUtilizador == 'Todos') selected @endif>Todos</option>
            <option value="F"     @if ($tipoUtilizador == 'F') selected @endif>Funcionarios</option>
            <option value="A"     @if ($tipoUtilizador == 'A') selected @endif>Administradores</option>
        </select>
        <!-- Tipo -->
    </div>  
    <div class="col-sm-5 col-md-2 .ml-md-auto" >
        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Pesquisar</button>
    </div>
</div>
</form>
<br>
<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Estado</th>
                <th scope="col">Tipo</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">
                <form method="get" action="{{route('users.funcionarios.create')}}">
                    <button style="float: right;" class="btn btn-outline-dark" href="{{route('users.funcionarios.store')}}">&nbspNovo&nbsp&nbsp</button>
                </form>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Funcionarios as $user)
            <tr>
                <td><img class="rounded" style="max-height: 50px; max-width: 50px;" src="/storage/fotos/{{($user->foto_url ?? 'default-profile.png')}}" alt="..." /></td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>@if($user->bloqueado===0) Ativo
                    @else Inativo
                    @endif
                </td>
                <td>@if($user->tipo == 'A') Administrador 
                    @else Funcionario 
                    @endif 
                </td>
                @if(is_null($user->deleted_at))
                    @if($user->bloqueado == 1)
                    <td>
                    <a href="{{ route('users.funcionarios.inativar', $user) }}" name="user" value='{{$user}}' class="btn btn-outline-success" role="button" aria-pressed="true">&nbspAtivar&nbsp&nbsp</a>
                    </td>
                    @else
                    <td>
                    <a href="{{ route('users.funcionarios.inativar', $user) }}" name="user" value='{{$user}}' class="btn btn-outline-danger" role="button" aria-pressed="true">Inativar</a>
                    </td>
                    @endif
                @else
                <td>
                </td>
                @endif
                @if(is_null($user->deleted_at))
                <td>
                <a href="{{ route('users.funcionarios.recuperar', $user) }}" name="user" value='{{$user}}' class="btn btn-outline-danger" role="button" aria-pressed="true">&nbsp&nbspEliminar&nbsp&nbsp</a>
                </td>
                @else
                <td>
                <a href="{{ route('users.funcionarios.recuperar', $user) }}" name="user" value='{{$user}}' class="btn btn-outline-success" role="button" aria-pressed="true">Recuperar</a>
                </td>
                @endif
                <td>
                <a href="{{ route('users.funcionarios.edit', $user) }}" name="user" value='{{$user}}' class="btn btn-outline-dark" role="button" aria-pressed="true">Alterar</a>
                </td> 
            </tr>
            @endforeach
        </tbody>
        
    </table>
    <div class="d-flex justify-content-center">
            {!! $Funcionarios->links() !!}
    </div>
</div>
@endsection