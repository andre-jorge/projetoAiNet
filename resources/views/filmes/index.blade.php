@extends('home')

@section('content')
<!--  Navbar Search -->
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Filme em Exibição</h1></strong></h3>
</div>
<br>
<br>
<form  action="/" method="GET">
<div class="row mb-2">
    <div class="col-sm-5 col-md-5">
        <!-- STRING -->
        <input type="search" name="string" id="string" class="form-control rounded" placeholder="Pesquisar por Nome ou Email" aria-label="Search" aria-describedby="search-addon" />    
        <!-- STRING --> 
    </div>
    <div class="col-sm-5 col-md-5">
    
        <!-- Tipo -->
        <select class="form-select" name="genero" id="inputGroupSelect04">
        @if($generoPedido != null)
                <option value="{{$generoPedido->code}}" selected>
                    {{$generoPedido->nome}}
                </option>
        @endif
            @foreach ($listaGeneros as $gen)
                <option value="{{$gen->code}}">
                    {{$gen->nome}}
                </option>
            @endforeach
        </select>
        <!-- Tipo -->
    </div>  
    <div class="col-sm-5 col-md-2 .ml-md-auto" >
        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Pesquisar</button>
    </div>
</div>
</form> 
<br>

<!-- FILMES -->
<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
    @foreach ($filmesAtuais as $filme) 
    
    <div class="col mb-10">
        <div class="card h-100">
        <div class="bg-image">
            <!-- Product image-->
            <img class="card-img-top" src="/storage/cartazes/{{$filme->Filmes->cartaz_url}}" alt="..." />
            <!-- Product details-->
            <div class="card-body p-4">
                <div class="text-center">
                    <!-- Product name-->
                    <h5 class="fw-bolder"><?= $filme->Filmes->titulo ?></h5>
                </div>
            </div>
            <!-- Product actions-->
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center">
                    <a class="btn btn-outline-dark mt-auto" name="filmeid" value='{{$filme->filme_id}}' href="{{ route('sessoes.index', $filme->filme_id) }}">Ver Sessoes</a>
                </div>
            </div>
        </div></div>
        </div>
    @endforeach

@endsection


