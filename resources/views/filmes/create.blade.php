@extends('home')

@section('content')
<form action="{{ route('filmes.store') }}" id="filmes-form" method="POST">
 @csrf
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Criar Filme</h3></div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="idTitulo" type="select" value="{{old('titulo')}}" placeholder="Insira o Nome do Filme">
                        <label for="idTitulo">Titulo</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating" >
                        <select class="form-select" name="curso" id="idGenero">
                            @foreach($Generos as $code => $nome)
                                <option value="{{$code}}" >{{$code}}</option>
                            @endforeach
                        </select>
                        <label for="idGenero_code">Genero</label>
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="idTCartaz_url" type="text" value="{{old('cartaz_url')}}" placeholder="234bjbdf.jpg"> 
                        <label for="idTCartaz_url">Cartaz URL</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="idAno" type="number" value="{{old('ano')}}" placeholder="2022">
                        <label for="idAno">Ano</label>
                    </div>
                </div>
            </div>
            
            <div class="form-floating mb-3">
                <input class="form-control" id="idSumario" type="text" value="{{old('sumario')}}" placeholder="Sumario"> 
                <label for="idSumario">Sumario</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="idTrailer" type="text" value="{{old('trailer_url')}}" placeholder="Sumario"> 
                <label for="idTrailer">Trailer URL</label>
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
