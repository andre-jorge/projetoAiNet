@extends('home')

@section('content')
<?php
$url = $filme->trailer_url;
preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
$idmatches = $matches[1] ?? 'sem imagem';
$width = '800px';
$height = '450px'; ?>

<div class="card h-300">
  <div class="text-center">
    <div class="card flex-md-row mb-4 box-shadow h-md-250">
      <img class="card-img-right flex-auto d-none d-md-block" src="/storage/cartazes/{{$filme->cartaz_url}}" alt="Thumbnail [200x250]" style="width: 300px; height: 450px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22200%22%20height%3D%22250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20200%20250%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_180e6792552%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A13pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_180e6792552%22%3E%3Crect%20width%3D%22200%22%20height%3D%22250%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2256.1953125%22%20y%3D%22131%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
        <div class="card-body d-flex flex-column align-items-start">
          <h3 class="mb-0"><strong><h1 class="card-title"><?= $filme->titulo ?></h1></strong></h3>
            <div class="mb-1 text-muted">Ano: <?= $filme->ano ?></div>
            <div class="mb-1 text-muted">Genero: <?= $filme->Generos->nome ?></div>
            <div class="mb-1 text-muted">Sumario: <?= $filme->sumario ?></div>  
        </div>
    </div>     
    <h4>TRAILER</h4>
    <div class="text-center">
      <iframe id="ytplayer" type="text/html" width="<?php echo $width ?>" height="<?php echo $height ?>"
          src="https://www.youtube.com/embed/<?php echo $idmatches ?>?rel=0&showinfo=0&color=white&iv_load_policy=3"
          frameborder="0" allowfullscreen></iframe> 
    </div>
    <div class="text-center">
    <br><br><br>
    <h3 class="mb-0"><strong><h1 class="card-title">Sessoes Disponiveis</h1></strong></h3>
    <br>
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">Dia Sessao</th>
                  <th scope="col">Hora</th>
                  <th scope="col">Sala</th>
                  <th scope="col">Lugares Ocupados</th>
                  <th scope="col">Lugares Livres</th>
                  <th scope="col">Total Capacidade Sala</th>
                  <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sessoesFilme as $sessao)
                <tr>
                  <td name="datafilme" value="<?= $sessao->data ?>"><?= $sessao->data ?></td>
                  <td name="horainicio" value="<?= $sessao->horario_inicio ?>"><?= $sessao->horario_inicio ?></td>
                  <td><?= $sessao->Salas->nome ?></td>
                  <td> 
                  @php echo App\Http\Controllers\SessoesController::ContaBilhetes($sessao->id);  @endphp
                  </td>
                  <td> 
                  @php echo ($sessao->Salas->custom)-(App\Http\Controllers\SessoesController::ContaBilhetes($sessao->id));  @endphp
                  </td>
                  <td><?= $sessao->Salas->custom ?></td>
                  <td>
                  @if(Auth::guest() or Auth::user()->tipo == 'C')
                    <form action="{{route('sessoes.lugares', $sessao)}}" id="form" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal" id="open">Reservar</button>
                        
                          </form>
                          
                        </td>
                        @endif
                      </tr>
                      
                  @endforeach
            </tbody>  
        </table>
        <div class="d-flex justify-content-center">
            {!! $sessoesFilme->links() !!}
        </div>          
    </div>              
  </div>
</div>
@endsection