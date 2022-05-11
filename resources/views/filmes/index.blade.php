@extends('welcome')

@section('content')
<h2>Filmes</h2>
    @foreach ($filmes as $filme) 
    <div class="col mb-5">
        <div class="card h-100">
            <!-- Product image-->
            <img class="card-img-top" src="/img/cursos/{{$filme->cartaz_url}}" alt="..." />
            <!-- Product details-->
            <div class="card-body p-4">
                <div class="text-center">
                    <!-- Product name-->
                    <h5 class="fw-bolder"><?= $filme->titulo ?></h5>
                    <span class="fw-bolder"><?= $filme->genero_code ?></span>
                    <!-- Product price-->
                    $40.00 - $80.00
                </div>
            </div>
            <!-- Product actions-->
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div>
            </div>
        </div>
        </div>
    @endforeach
@endsection