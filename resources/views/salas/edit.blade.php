@extends('home')
@section('title','Alterar Filme' )
@section('content')
<form action="{{ route('salas.update', $sala->id) }}" id="salas-form" method="POST">
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar Sala</h3></div>  
    <div class="card-body">
    @csrf
    @method('PUT')    
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <a value="{{$sala->nome}}"></a>
                        <input class="form-control" name="nome" id="idnome" type="text" value="{{$sala->nome}}" placeholder="Nome Sala"> 
                        @error('nome')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idnome">Nome Sala</label>
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
