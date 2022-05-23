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
            @foreach ($Clientes as $dados)
            <tr>
                <td>{{$dados->id}}</td>
                <td>{{$dados->name}}</td>
                <td>{{$dados->email}}</td>
                <td>{{$dados->tipo}}</td>
                <td>{{$dados->nif}}</td>
                <td>{{$dados->tipo_pagamento}}</td>
                <td>{{$dados->ref_pagamento}}</td>
            </tr>
            @endforeach
        </tbody>
        
    </table>
    {{ $Clientes->links() }}
</div> 

@endsection