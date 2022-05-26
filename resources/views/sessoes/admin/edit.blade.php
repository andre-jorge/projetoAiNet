@extends('home')
@section('title','Alterar Sessao' )
@section('content')
<form action="{{ route('sessoes.admin.update', $sessao->id) }}" id="sessoes-form" method="POST">
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar Sessao</h3></div>  
    <div class="card-body">
    @csrf
    @method('PUT')    
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <a value="{{$sessao->data}}"></a>
                        <input class="form-control" name="data" id="iddata" type="text" value="{{$sessao->data}}" placeholder="Data"> 
                        @error('nome')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idnome">Data Sessao</label>
                    </div>
                    <div class="form-floating mb-3 mb-md-0">
                        <a value="{{$sessao->horario_inicio}}"></a>
                        <input class="form-control" name="horario_inicio" id="idhorario_inicio" type="text" value="{{$sessao->horario_inicio}}" placeholder="Hora"> 
                        @error('nome')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idnome">Hora Sessao</label>
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
@endsection
