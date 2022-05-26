@extends('home')

@section('content')
<form action="{{ route('sessoes.admin.store') }}" id="filmes-form" method="POST">
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Criar Sessao</h3></div>
       
    <div class="card-body">
    @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="horario_inicio" id="horario_inicio" type="time" step="2" value="{{old('horario_inicio')}}" placeholder="Hora">
                        @error('horario_inicio')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="horario_inicio">Hora</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating" >
                        <select class="form-select" name="filme_id" id="filme_id">
                            @foreach($listaFilmes as $titulo => $id)
                                <option value="{{$id}}" {{old('titulo')==$titulo?'selected':''}}>{{$titulo}}</option>
                            @endforeach
                        </select>
                        @error('titulo')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="filme_id">Filme</label>
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="data" id="data" type="date" value="{{old('data')}}" placeholder="Data"> 
                        @error('data')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="data">Data</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating" >
                        <select class="form-select" name="sala_id" id="sala_id">
                            @foreach($listaSalas as $nome => $id)
                                <option value="{{$id}}" {{old('nome')==$nome?'selected':''}}>{{$nome}}</option>
                            @endforeach
                        </select>
                        @error('sala_id')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="filme_id">Sala</label>
                    </div>
                </div>
            </div>
            <div class="mt-4 mb-0">
                <div class="d-grid">
                    <button class="btn btn-primary btn-block" type="submit">Criar Filme</button>
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
