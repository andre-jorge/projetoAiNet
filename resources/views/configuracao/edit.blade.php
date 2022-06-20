@extends('home')
@section('title','Alterar Preços' )
@section('content')
<form action="{{ route('configuracao.update', $configs->id) }}" id="bilhetes-form" method="POST">
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar Preços Bilhetes</h3></div>  
    <div class="card-body">
    @csrf
    @method('PUT')    
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <a value="{{$configs->preco_bilhete_sem_iva}}"></a>
                        <input class="form-control" name="preco_bilhete_sem_iva" id="preco_bilhete_sem_iva" type="text" value="{{$configs->preco_bilhete_sem_iva}}" placeholder="Preço S/iva"> 
                        @error('preco_bilhete_sem_iva')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="preco_bilhete_sem_iva">Preço Bilhete S/iva</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <a value="{{$configs->percentagem_iva}}"></a>
                        <input class="form-control" name="percentagem_iva" id="percentagem_iva" type="text" value="{{$configs->percentagem_iva}}" placeholder="Iva"> 
                        @error('percentagem_iva')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="percentagem_iva">Iva</label>
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
