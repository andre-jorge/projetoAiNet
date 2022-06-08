@extends('home')

@section('content')  
<div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">name</th>
                <th scope="col">email</th>
                <th scope="col">tipo</th>
                <th scope="col">nif</th>
                <th scope="col">tipo_pagamento</th>
                <th scope="col">ref_pagamento</th>
                </tr>
        </thead>
        <tbody>
            @foreach ($dadosClientes as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->tipo}}</td>
                <td>{{$user->nif}}</td>
                <td>{{$user->Cliente->tipo_pagamento ?? ' '}} </td>
                <td>{{$user->Cliente->ref_pagamento ?? ' '}}</td>
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
                    <form method="post" action="{{ route('users.funcionarios.destroy', $user) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Pretende eleminar?')" value="Eliminar">
                    </form> 
                </td>
                </tr>
            </tr>
            @endforeach
        </tbody>
        
    </table>
    <div class="d-flex justify-content-center">
            {!! $dadosClientes->links() !!}
    </div>
</div> 



<div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">name</th>
                <th scope="col">email</th>
                <th scope="col">tipo</th>
                <th scope="col">nif</th>
                <th scope="col">tipo_pagamento</th>
                <th scope="col">ref_pagamento</th>
                </tr>
        </thead>
        <tbody>
            @foreach ($dadosClientesDeleted as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->tipo}}</td>
                <td>{{$user->nif}}</td>
                <td>{{$user->Cliente->tipo_pagamento ?? ' '}} </td>
                <td>{{$user->Cliente->ref_pagamento ?? ' '}}</td>
                <td>
                <a href="{{  route('users.funcionarios.recuperar', $user) }}" name="user" value='{{$user}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Inativar</a>
                </td>
                </tr>
            </tr>
            @endforeach
        </tbody>
        
    </table>
    <div class="d-flex justify-content-center">
            {!! $dadosClientesDeleted->links() !!}
    </div>
</div> 

@endsection