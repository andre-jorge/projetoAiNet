@extends('home')

@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Todas as sessoes do Filme</h1></strong></h3>
</div>
<form  action="{{route('estatisticas.bilhetes.sessoes', $filme)}}" method="GET">
<div class="row mb-2">
    <div class="col-sm-10 col-md-10">
        <!-- tipo_pagamento -->
        <select class="form-select" name="ordenar" id="ordenar">
                <option value="TODOS">Ordenar</option>
                <option value="1">Taxa de ocupação ASC</option>
                <option value="2">Taxa de ocupação DESC</option>
        </select>
        <!-- tipo_pagamento -->
    </div>  
    <div class="col-sm-5 col-md-2 .ml-md-auto" >
        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Pesquisar</button>
        
    </div>
</div>
</form>
    <br>
        <table class="table table-striped">
            <thead>
                <tr>
                  <th scope="col">Nº Sessao</th>
                  <th scope="col">Data</th>
                  <th scope="col">Hora</th>
                  <th scope="col">Bilhetes Disponiveis</th>
                  <th scope="col">Bilhetes Vendidos</th>
                  <th scope="col">Bilhetes Usado</th>
                  <th scope="col">Bilhetes Não Usados</th>
                  <th scope="col">Taxa de Ocupação da Sessao (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sessoesFilme as $sessao)
                <tr>
                    <td><?= $sessao->id ?></td>
                    <td><?= $sessao->data ?></td>
                    <td><?= $sessao->horario_inicio ?></td>
                    <td><?= $sessao->BilhetesVendidos ?></td>
                    <td><?= $sessao->Naousados ?></td>
                    <td><?= $sessao->Usados ?></td>
                    <td><?= $sessao->Naousados ?></td>
                    <td><?= $sessao->TaxaOcupação ?> %</td>
                </tr>
                @endforeach
            </tbody>  
        </table>   
    </div>              
  </div>
</div>


@endsection