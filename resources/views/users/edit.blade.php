@extends('home')

@section('content')  
<form action="{{ route('users.edit', $clientes) }}" enctype="multipart/form-data" id="funcs-form" method="POST">
@csrf
@method('PUT')
<div class="card-header"><h3 class="text-center font-weight-light my-4">Dados Cliente</h3></div> 
    <div class="card-body">
   
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="nome" id="idnome" type="select" value="{{$clientes->name}}" placeholder="Nome">
                        @error('titulo')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idTitulo">Nome</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="nif" id="idemail" type="select" value="{{$clientes->nif}}" placeholder="NIF">
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idTitulo">NIF</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="nome" id="idnome" type="select" value="{{$clientes->tipo_pagamento}}" placeholder="Nome">
                        @error('dados_pagamento')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="idTitulo">Dados Pagamento</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" name="foto_url" id="foto_url" type="file" value="{{$clientes->foto_url}}" placeholder="Foto">
                        @error('foto_url')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <label for="foto_url">Foto/Avatar</label>
                    </div>
                </div>
            </div>            
            <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                    @if (Route::has('password.request'))
                        <a class="btn btn-primary" href="{{ route('password.request') }}">
                            {{ __('Alterar Password') }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="mt-4 mb-0">
                <div class="d-grid">
                    <button class="btn btn-primary btn-block" type="submit">Concluido</button>
                </div> 
            </div>
        </div>
    </div>

@endsection