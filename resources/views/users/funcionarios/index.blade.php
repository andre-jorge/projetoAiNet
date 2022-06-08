@extends('home')

@section('content')
 
<form method="get" action="{{route('users.funcionarios.create')}}">
    <button style="float: right;" class="btn btn-secondary btn-lg" href="{{route('users.funcionarios.store')}}">Novo</button>
</form> 
<div class="container text-center">
<h3 class="align-middle"><strong><h1 class="align-middle">Funcionarios</h1></strong></h3>
</div>
<div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Estado</th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
        </thead>
        <tbody>
            @foreach ($Funcionarios as $user)
            <tr>
                <td><img class="rounded" style="max-height: 50px; max-width: 50px;" src="/storage/fotos/{{$user->foto_url}}" alt="..." /></td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>@if($user->bloqueado===0) Ativo
                    @else Inativo
                    @endif
                </td>
                @if($user->bloqueado == 1)
                <td>
                <a href="{{ route('users.funcionarios.inativar', $user) }}" name="user" value='{{$user}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Ativar</a>
                </td>
                @else
                <td>
                <a href="{{ route('users.funcionarios.inativar', $user) }}" name="user" value='{{$user}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Inativar</a>
                </td>
                @endif
                <td>
                <a href="{{ route('users.funcionarios.edit', $user) }}" name="user" value='{{$user}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Alterar</a>
                </td>
                <td>
                    <form method="post" action="{{ route('users.funcionarios.destroy', $user) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Pretende eleminar?')" value="Eliminar">
                    </form> 
                </tr>
            </tr>
            @endforeach
        </tbody>
        
    </table>
    <div class="d-flex justify-content-center">
            {!! $Funcionarios->links() !!}
    </div>
</div>
<div class="container text-center">
<h3 class="align-middle"><strong><h1 class="align-middle">Administradores</h1></strong></h3>
</div>
<div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Bloqueado?</th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
        </thead>
        <tbody>
            @foreach ($Admins as $user)
            <tr>
                <td><img class="rounded" style="max-height: 50px; max-width: 50px;" src="/storage/fotos/{{$user->foto_url}}" alt="..." /></td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>@if($user->bloqueado===0) Ativo
                    @else Inativo
                    @endif
                </td>
                @if($user->bloqueado == 1)
                <td>
                <a href="{{ route('users.funcionarios.inativar', $user) }}" name="user" value='{{$user}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Ativar</a>
                </td>
                @else
                <td>
                <a href="{{ route('users.funcionarios.inativar', $user) }}" name="user" value='{{$user}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Inativar</a>
                </td>
                @endif
                <td>
                <a href="{{ route('users.funcionarios.edit', $user) }}" name="user" value='{{$user}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Alterar</a>
                </td>
                <td>
                    <form method="post" action="{{ route('users.funcionarios.destroy', $user) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Pretende eleminar?')" value="Eliminar">
                    </form> 
                </tr>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
            {!! $Admins->links() !!}
        </div>
</div> 

@endsection