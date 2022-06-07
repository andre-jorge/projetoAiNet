@extends('home')

@section('content')
<form action="{{ route('filmes.store') }}" enctype="multipart/form-data" id="filmes-form" method="POST">
    
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Criar Filme</h3></div>
       
    <div class="card-body">
    @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="titulo" id="idTitulo" type="select" value="{{old('titulo')}}" placeholder="Insira o Nome do Filme">
                        @error('titulo')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idTitulo">Titulo</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating" >
                        <select class="form-select" name="genero_code" id="idGenero">
                            @foreach($listaGeneros as $nome => $code)
                                <option value="{{$code}}" {{old('nome')==$nome?'selected':''}}>{{$nome}}</option>
                            @endforeach
                        </select>
                        @error('code')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idGenero_code">Genero</label>
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="cartaz_url" id="cartaz_url" type="file" value="{{old('cartaz_url')}}" placeholder="">  
                        @error('cartaz_url')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idCartaz_url">Cartaz URL</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="ano" id="idAno" type="number" value="{{old('ano')}}" placeholder="2022">
                        @error('ano')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idAno">Ano</label>
                    </div>
                </div>
            </div>
            
            <div class="form-floating mb-3">
                <input class="form-control" id="idSumario" name="sumario" type="text" value="{{old('sumario')}}" placeholder="Sumario"> 
                @error('sumario')
                    <div class="error">{{ $message }}</div>
                @enderror
                <label for="idSumario">Sumario</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="idTrailer_url" name="trailer_url" type="text" value="{{old('trailer_url')}}" placeholder="Sumario"> 
                @error('trailer_url')
                    <div class="error">{{ $message }}</div>
                @enderror
                <label for="idTrailer_url">Trailer URL</label>
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
