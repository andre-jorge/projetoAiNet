@extends('home')

@section('content')



    <div class="card h-50">
        <div class="card-body p-10">
            <div class="text-center">
                
                    <div class="row">
                        <div class="col-3">
                            <img src="/storage/cartazes/{{$filme->cartaz_url}}" class="img-fluid" alt="">
                        </div>
                        <div class="col">
                            <div class="card-block px-2">
                                <h4 class="card-title"><?= $filme->titulo ?></h4>
                                <span class="float-left"><?= $filme->sumario ?></span>
                                <span class="float-left"><?= $filme->ano ?> </span>
                            </div>
                        </div>
                    <table class="table">
                    <thead>
                        <tr>
                        
                        <th scope="col">Dia Sessao</th>
                        <th scope="col">Hora</th>
                        <th scope="col">sala_id</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessoesFilme as $sessao)
                        <tr>
                        <td><?= $sessao->data ?></td>
                        <td><?= $sessao->horario_inicio ?></td>
                        <td><?= $sessao->nome ?></td>
                        </tr>
                        @endforeach
                    </tbody>
                    
            </div>
        </div>
    </div>

@endsection