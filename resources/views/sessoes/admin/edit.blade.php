@extends('home')
@section('title','Alterar Sessao' )
@section('content')

<form action="{{ route('sessoes.admin.update', $sessao->id) }}" id="salas-form" method="POST">
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar Sessao</h3></div>  
    <div class="card-body">
    @csrf
    @method('PUT')
    
    <h5 class="fw-bolder">Filme :<?= $sessao->filmes->titulo ?></h5>    
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="data" id="date" type="date" value="{{$sessao->data}}" placeholder="Data"> 
                        @error('data')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="data">Data</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <a value="{{$sessao->horario_inicio}}"></a>
                        <input class="form-control" name="horario_inicio" id="horario_inicio" type="time" step="2" value="{{$sessao->horario_inicio}}" placeholder="Horario Inicio"> 
                        @error('horario_inicio')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="horario_inicio">Horario Inicio</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" name="sala_id" id="sala_id">
                            @foreach($listaSalas as $nome => $id)
                                <option value="{{$id}}">{{$nome}}</option>
                            @endforeach
                        </select>
                        @error('nome')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="filme_id">Sala</label>
                    </div>
                </div>
            </div>  
            <div class="mt-4 mb-0">
                <div class="d-grid">
                    <button class="btn btn-primary btn-block" type="submit">Concluido</button>
                </div> 
            </div>
        </div>
    </div>
</form>
<!-- <div class="bt-area">
        <button type="submit" class="bt">Criar</button>
        <button type="reset" class="bt">Apagar</button>
    </div> -->

@endsection
