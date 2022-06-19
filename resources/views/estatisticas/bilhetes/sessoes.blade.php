@extends('home')

@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Todas as sessoes do Filme</h1></strong></h3>
</div>
    <br>
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">Nº Sessao</th>
                  <th scope="col">Data</th>
                  <th scope="col">Hora</th>
                  <th scope="col">Sala</th>
                  <th scope="col">Bilhetes Disponiveis</th>
                  <th scope="col">Bilhetes Vendidos</th>
                  <th scope="col">Bilhetes Usado</th>
                  <th scope="col">Bilhetes Não Usados</th>
                  <th scope="col">Taxa de Ocupação da Sessao</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sessoesFilme as $sessao)
                <tr>
                    <td><?= $sessao->id ?></td>
                    <td><?= $sessao->data ?></td>
                    <td><?= $sessao->horario_inicio ?></td>
                    <td><?= $sessao->Salas->nome ?></td>
                    <td> 
                        @php echo App\Http\Controllers\EstatisticasController::totalLugaresSessao($sessao->id);  @endphp
                    </td>
                    <td> 
                        @php echo App\Http\Controllers\EstatisticasController::totalBilhetesVendidos($sessao->id);  @endphp
                    </td>
                    <td> 
                        @php echo App\Http\Controllers\EstatisticasController::totalBilhetesVendidosUsados($sessao->id);  @endphp
                    </td>
                    <td> 
                        @php echo App\Http\Controllers\EstatisticasController::totalBilhetesVendidosNaoUsados($sessao->id);  @endphp
                    </td>
                    <td> 
                        @php echo App\Http\Controllers\EstatisticasController::taxaOcupacaoSessao($sessao->id);  @endphp
                    </td>
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