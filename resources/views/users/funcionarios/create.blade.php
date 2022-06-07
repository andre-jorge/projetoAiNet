@extends('home')
@section('title','Criar Funcionario' )
@section('content')
<form action="{{ route('users.funcionarios.store') }}" enctype="multipart/form-data" id="funcs-form" method="POST">
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Novo</h3></div>  
    <div class="card-body">
    @csrf   
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="name" id="name" type="text" value="{{old('name')}}" placeholder="Nome"> 
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="name">Nome</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="email" id="email" type="email" value="{{old('email')}}" placeholder="Email"> 
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
                        <input class="form-control" name="foto_url" id="foto_url" type="file" value="{{old('foto_url')}}">  
                        @error('foto_url')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="foto_url">Foto</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="password" id="password" type="password" value="{{old('password')}}" placeholder="Password"> 
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="password">Password</label>
                    </div>
                </div>
            </div>    
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="gridRadios1" value="F" checked>
                            <label class="form-check-label" for="gridRadios1">
                                Funcionario
                            </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="gridRadios2" value="A">
                            <label class="form-check-label" for="gridRadios2">
                                Administrador
                            </label>
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
