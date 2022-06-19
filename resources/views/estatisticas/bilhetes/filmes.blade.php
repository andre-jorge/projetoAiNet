@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Estatisticas Filmes|Sessoes</h1></strong></h3>
</div>
<br>
<form  action="{{route('filmes.admin')}}" method="GET">
<div class="row mb-2">
    <div class="col-sm-5 col-md-5">
        <!-- STRING -->
        <input type="search" name="string" id="string" class="form-control rounded" placeholder="Pesquisar por Nome ou Email" aria-label="Search" aria-describedby="search-addon" />    
        <!-- STRING --> 
    </div>
    <div class="col-sm-5 col-md-5">

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
                <th scope="col">titulo</th>
                <th scope="col"></th>
                </tr>
        </thead>
        <tbody>
            @foreach ($filmes as $filme)
            <tr>
                <td><img class="rounded" style="max-height: 100px; max-width: 100px;" src="/storage/cartazes/{{$filme->cartaz_url}}" alt="..." /></td>
                <td>{{$filme->titulo}}</td>
                <td>
                <a class="btn btn-outline-dark mt-auto" name="filmeid" value='{{$filme}}' href="{{ route('estatisticas.bilhetes.sessoes', $filme) }}">Selecionar</a>
                </td>              
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
            {!! $filmes->links() !!}
    </div>
</div>
@endsection