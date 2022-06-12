@extends('home')

@section('content')
<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
    @foreach ($todasSessoesFilmesHoje as $filme)  
    <div class="col mb-10">
        <div class="card h-100">
        <img class="card-img-left" src="/storage/cartazes/{{$filme->Filmes->cartaz_url}}" alt="..." />
            <div class="card-body p-4">
                <div class="text-center">
                    <!-- Product name-->
                    <h5 class="fw-bolder"><?= $filme->titulo ?></h5>
                    <h5 class="fw-bolder"><?= $filme->data ?></h5>
                    <h5 class="fw-bolder"><?= $filme->horario_inicio ?></h5>
                    <div class="text-center">
                    <a class="btn btn-outline-dark mt-auto" name="filmeid" value='{{$filme->sala_id}}' href="{{ route('sessoes.edit', $filme->sala_id) }}">Validar Sessões</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection