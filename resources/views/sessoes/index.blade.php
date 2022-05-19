@extends('home')

@section('content')
@foreach ($Filme as $filme)
<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $filme->titulo ?></h1>
    <div class="card h-100">
        <div class="card-body p-10">
            <div class="text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-4"  >
                            <img width="300" height="435"  src="/storage/cartazes/{{$filme->cartaz_url}}" alt="..." /></img>
                        </div>
                        <div >
                            <p class="font-weight-bold"><?= $filme->sumario ?></p>
                            <small class="float-left">Ano: <?= $filme->ano ?></small><p></p>
                            <small> Genero:<?= $filme->genero ?>Texto de espessura leve.</small>
                        </div>
                    </div>
                </div>
                    <table class="table">
                    <thead>
                        <tr>
                        
                        <th scope="col">Dia Sessao</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Filme_id</th>
                        <th scope="col">sala_id</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessoesFilme as $sessao)
                        <tr>
                        <td><?= $sessao->data ?></td>
                        <td><?= $sessao->horario_inicio ?></td>
                        <td><?= $sessao->filme_id ?></td>
                        <td><?= $sessao->sala_id ?></td>
                        </tr>
                        @endforeach
                    </tbody>
                    
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection