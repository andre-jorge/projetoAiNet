@extends('home')
@section('title','Editar' )
@section('content')
<form action="{{ route('users.funcionarios.update', $funcionario) }}" enctype="multipart/form-data" id="funcs-form" method="POST">
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar</h3></div>  
    <div class="card-body">
    @csrf
    @method('PUT')    
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <a value="{{$funcionario->name}}"></a>
                        <input class="form-control" name="name" id="name" type="text" value="{{$funcionario-> name}}" placeholder="Nome"> 
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="name">Nome</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <a value="{{$funcionario->email}}"></a>
                        <input class="form-control" name="email" id="email" type="email" value="{{$funcionario->email}}" placeholder="Email"> 
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="email">Email</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <a value="{{$funcionario->foto_url}}"></a>
                        <input class="form-control" name="foto_url" id="foto_url" type="text" value="{{$funcionario->foto_url}}" placeholder="Foto"> 
                        @error('foto_url')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="foto_url">Foto</label>
                    </div>
                </div>

                <div class="col-md-6">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <a value="{{$funcionario->tipo}}"></a>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="F" required @if($funcionario->tipo == 'F') checked @endif>
                            <label class="form-check-label" for="gridRadios1">
                                Funcionario
                            </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="A" @if($funcionario->tipo == 'A') checked @endif>
                            <label class="form-check-label" for="gridRadios2">
                                Administrador
                            </label>
                            </div>
                        </div>
                    </div>
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
