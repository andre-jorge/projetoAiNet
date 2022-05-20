@extends('home')

@section('content')
<?php
$url = $filme->trailer_url;
preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
$id = $matches[1];
$width = '800px';
$height = '450px'; ?>



    <div class="card h-300">
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
                        <p>
                        </p>
                        <h4>TRAILER</h4>
                        <div class="text-center">
                        <iframe id="ytplayer" type="text/html" width="<?php echo $width ?>" height="<?php echo $height ?>"
                            src="https://www.youtube.com/embed/<?php echo $id ?>?rel=0&showinfo=0&color=white&iv_load_policy=3"
                            frameborder="0" allowfullscreen></iframe> 
                        </div>
                    <table class="table">
                    <thead>
                        <tr>
                        
                        <th scope="col">Dia Sessao</th>
                        <th scope="col">Hora</th>
                        <th scope="col">sala_id</th>
                        <th scope="col">BILHETES TODOS COMPRADOS???</th>
                        <th scope="col">sala_id</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessoesFilme as $sessao)
                        <tr>
                        <td><?= $sessao->data ?></td>
                        <td><?= $sessao->horario_inicio ?></td>
                        <td><?= $sessao->nome ?></td>
                        <td><?= $sessao->nome ?></td>
                        <td><?= $sessao->nome ?></td>
                        </tr>
                        @endforeach
                    </tbody>
                    
            </div>
    </div>

@endsection