@extends('home')

@section('content')
<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
    @foreach ($filmes as $filme) 
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
                    @foreach ($sessoes as $sec)
                    <span class="fw-bolder"><?= $sec->filme_id ?></span>
                    @endforeach 
                </div>
            </div>
            <!-- Product actions-->
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href=""><?= $filme->id ?></a></div>
            </div>
        </div>
        </div>
    @endforeach
    </div>
    <div>
    {{ $filmes->links() }}
</div>
@endsection