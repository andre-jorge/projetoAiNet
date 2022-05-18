@extends('home')

@section('content')
<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
    @foreach ($Filmeinfo as $filme) 
    <div class="col mb-5">
        <div class="card h-100">
            <!-- Product image-->
            <img class="card-img-top" src="/storage/cartazes/{{$filme->cartaz_url}}" alt="..." />
            <!-- Product details-->
            <div class="card-body p-4">
                <div class="text-center">
                    <!-- Product name-->
                    <h5 class="fw-bolder"><?= $filme->titulo ?></h5>
                    <span class="fw-bolder"><?= $filme->genero_code ?></span>
                </div>
            </div>
        </div>
        </div>
    @endforeach
    </div>
@endsection