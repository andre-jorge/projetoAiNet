@extends('home')

@section('content')
<form action="{{ route('salas.store') }}" id="salas-form" method="POST">
    <div class="card-header">
            <h3 class="text-center font-weight-light my-4">Criar Sala</h3>
            <span style="width: 100%;" text-align="center">Esta funcao irá criar a sala e respetivos lugares segundo o numero de lugares e filas</span>
    </div> 
    <div class="card-body">
    @csrf
    
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="nome" id="idnome" type="text" value="{{old('nome')}}" placeholder="Nome Sala"> 
                        @error('nome')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idnome">Nome Sala</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="lugares" id="lugares" type="number" value="{{old('custom')}}" placeholder="lugares"> 
                        @error('custom')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="costum">Lugares</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="filas" id="filas" type="number" value="{{old('custom')}}" placeholder="filas"> 
                        @error('custom')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="costum">Filas</label>
                    </div>
                </div>
                <input type="hidden" class="form-control" name="custom" value="0" >
                <!-- <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="custom" id="custom" type="number" value="{{old('custom')}}" placeholder="Lotação Max."> 
                        @error('custom')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="costum">Lotação Maxima</label>
                    </div>
                </div> -->
            </div>  
            <div class="mt-4 mb-0">
                <div class="d-grid">
                    <button class="btn btn-primary btn-block" type="submit">Criar Sala</button>
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
