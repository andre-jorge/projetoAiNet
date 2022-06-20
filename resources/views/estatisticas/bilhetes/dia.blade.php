@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Dashboard Diario {{$dataInicioxpto}}</h1></strong></h3>
</div>

<div class="container-fluid px-4">
                        <form  action="{{route('estatisticas.bilhetes.dia')}}" method="GET">
                            <div class="row mb-2">
                                <div class="col-sm-10 col-md-10">
                                <br><br>
                                    <!-- STRING -->
                                    <input type="date" name="data" id="data" class="form-control rounded" placeholder="Data" aria-label="Search" aria-describedby="search-addon" value="{{$dataInicio}}"/>    
                                    <!-- STRING --> 
                                </div>  
                                <div class="col-sm-5 col-md-2 .ml-md-auto" >
                                <br><br>
                                    <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Pesquisar</button>
                                </div>
                            </div>
                        </form>                        
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total Bilhetes Vendidos</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{$totalBilhetesVendidosDia}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total de Sessoes</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{$totalSessoesDia}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Filmes a Decorrer</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{$sessoesFilmes}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                
                            </div>
                        </div>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Totais</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Recibos Emitidos</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{$totalRecibosCount}}
                                    </div>
                                </div>
                            </div>
                            @foreach ($totaisDiarios as $totais)
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Total Recibos S/IVA</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{$totais->PrecoTotalSiva}} €
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Total Recibos Iva</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    {{$totais->iva}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Total Recibos Emitidos</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    {{$totais->PrecoTotalCiva}} €
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Cliente</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total Clientes Ativos</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{$totalCliente}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Novos Clientes Hoje </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{$clientesNovosHoje}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Clientes Bloqueados</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{$clientesBloqueados}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Clientes Eliminados</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{$clientesEleminados}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <svg class="svg-inline--fa fa-table me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="table" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M448 32C483.3 32 512 60.65 512 96V416C512 451.3 483.3 480 448 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H448zM224 256V160H64V256H224zM64 320V416H224V320H64zM288 416H448V320H288V416zM448 256V160H288V256H448z"></path></svg><!-- <i class="fas fa-table me-1"></i> Font Awesome fontawesome.com -->
                                Top Clientes ultimos 7 dias
                            </div>
                            <div class="card-body">
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                    <div class="dataTable-container">
                                        <table id="datatablesSimple" class="dataTable-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Nome</th>
                                                    <th scope="col">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($melhoresClientes7Dias as $topcliente)
                                                <tr>
                                                    <td>{{$topcliente->id}}</td>
                                                    <td>{{$topcliente->name}}</td>
                                                    <td>{{$topcliente->soma}}</td>              
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="card mb-4">
                            <div class="card-header">
                                <svg class="svg-inline--fa fa-table me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="table" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M448 32C483.3 32 512 60.65 512 96V416C512 451.3 483.3 480 448 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H448zM224 256V160H64V256H224zM64 320V416H224V320H64zM288 416H448V320H288V416zM448 256V160H288V256H448z"></path></svg><!-- <i class="fas fa-table me-1"></i> Font Awesome fontawesome.com -->
                                Top Clientes ultimos 30 dias
                            </div>
                            <div class="card-body">
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                    <div class="dataTable-container"><table id="datatablesSimple" class="dataTable-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($melhoresClientes30Dias as $topcliente)
                                        <tr>
                                            <td>{{$topcliente->id}}</td>
                                            <td>{{$topcliente->name}}</td>
                                            <td>{{$topcliente->soma}}</td>              
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
@endsection